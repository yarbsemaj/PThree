<?php

namespace Tests\Feature\Question;

use App\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageSelectTest extends TestCase
{

    private $user;

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }

    /**
     * Adding the test.
     *
     * @return void
     */
    public function test_add_test()
    {
        $this->actingAs($this->user)
            ->post(route('order.store'),
                ['name' => 'example-name', 'description' => 'example-description',
                    'words' => ['word 1', 'word 2']])
            ->assertRedirect(route('order.index'));

        $this->actingAs($this->user)
            ->get(route('order.index'))
            ->assertSeeText('example-name');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->get(route('order.show', ['id' => $test->id]))
            ->assertSeeText('word 1')->assertSeeText('word 2');

    }

    public function test_user_test_isolation()
    {
        $this->actingAs($this->user)
            ->post(route('order.store'),
                ['name' => 'example-name', 'description' => 'example-description',
                    'words' => ['word 1', 'word 2']])
            ->assertRedirect(route('order.index'));

        $this->actingAs(factory('App\User')->create())
            ->get(route('order.index'))
            ->assertDontSeeText('example-name');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs(factory('App\User')->create())
            ->get(route('order.show', ['id' => $test->id]))
            ->assertRedirect(route('home'));

    }

    /**
     * Adding the test when not logged in
     *
     * @return void
     */
    public function test_add_no_user_test()
    {
        $this->post(route('order.store'),
            ['name' => 'example-name-no-user', 'description' => 'example-name-no-user', 'words' => ['word 1']])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tests', ['name' => 'example-name-no-user']);

    }

    /**
     * Adding the test.
     *
     * @return void
     */
    public function test_add_test_no_name()
    {
        $this->actingAs($this->user)
            ->post(route('order.store'),
                ['description' => 'example-description-no-name']);

        $this->assertDatabaseMissing('tests', ['description' => 'example-description-no-name']);
    }

    /**
     * Updating a free Test Test
     *
     * @return void
     */
    public function test_edit_test()
    {
        $this->actingAs($this->user)
            ->post('order',
                ['name' => 'example-name', 'description' => 'example-description', 'words' => ['word 1', 'word 2']])
            ->assertRedirect(route('order.index'));

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->put(route('order.update', ['id' => $test->id]),
                ['name' => 'example-name-update', 'description' => 'example-description', 'words' => ['word 2', 'word 3']])
            ->assertRedirect(route('order.index'));

        $this->actingAs($this->user)
            ->get('order')
            ->assertSeeText('example-name-update');

        $this->actingAs($this->user)
            ->get(route('order.show', ['id' => $test->id]))
            ->assertSeeText('word 3')->assertDontSeeText('word 1');

    }

    public function test_edit_for_another_user()
    {
        $this->actingAs($this->user)
            ->post('order',
                ['name' => 'example-name', 'description' => 'example-description', 'words' => ['word 1']])
            ->assertRedirect('order');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs(factory('App\User')->create())
            ->put(route('order.update', ['id' => $test->id]),
                ['name' => 'example-name-update', 'description' => 'example-description', 'words' => ['word 1']])
            ->assertRedirect(route('home'));

        $this->actingAs($this->user)
            ->get('order')
            ->assertSeeText('example-name');
    }

    /**
     * Removing a test
     *
     * @return void
     */
    public function test_remove_test()
    {
        $this->actingAs($this->user)
            ->post('order',
                ['name' => 'example-name', 'description' => 'example-description', 'words' => ['word 1']])
            ->assertRedirect('order');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->delete(route('order.destroy', ['id' => $test->id]));

        $this->actingAs($this->user)
            ->get('order')
            ->assertDontSeeText('example-name');

    }
}
