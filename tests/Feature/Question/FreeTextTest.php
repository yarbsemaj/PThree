<?php

namespace Tests\Feature\Question;

use App\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FreeTextTest extends TestCase
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
            ->post(route('free-text.store'),
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect(route('free-text.index'));

        $this->actingAs($this->user)
            ->get(route('free-text.index'))
            ->assertSeeText('example-name');

    }

    public function test_user_test_isolation()
    {
        $this->actingAs($this->user)
            ->post(route('free-text.store'),
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect(route('free-text.index'));

        $this->actingAs(factory('App\User')->create())
            ->get(route('free-text.index'))
            ->assertDontSeeText('example-name');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs(factory('App\User')->create())
            ->get(route('free-text.show', ['id' => $test->id]))
            ->assertRedirect(route('home'));

    }

    /**
     * Adding the test when not logged in
     *
     * @return void
     */
    public function test_add_no_user_test()
    {
        $this->post(route('free-text.store'),
            ['name' => 'example-name-no-user', 'description' => 'example-description'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('tests', ['name' => 'example-name-no-user']);

    }

    /**
     * Adding the test with name.
     *
     * @return void
     */
    public function test_add_test_no_name()
    {
        $this->actingAs($this->user)
            ->post(route('free-text.store'),
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
            ->post('free-text',
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect('free-text');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs(factory('App\User')->create())
            ->put(route('free-text.update', ['id' => $test->id]),
                ['name' => 'example-name-update', 'description' => 'example-description'])
            ->assertRedirect(route('home'));

        $this->assertDatabaseMissing('tests', ['name' => 'example-name-update']);


    }

    public function test_edit_for_another_user()
    {
        $this->actingAs($this->user)
            ->post('free-text',
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect('free-text');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->put(route('free-text.update', ['id' => $test->id]),
                ['name' => 'example-name-update', 'description' => 'example-description'])
            ->assertRedirect(route('free-text.index'));

        $this->actingAs($this->user)
            ->get('free-text')
            ->assertSeeText('example-name-update');
    }

    /**
     * Removing a test
     *
     * @return void
     */
    public function test_remove_test()
    {
        $this->actingAs($this->user)
            ->post('free-text',
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect('free-text');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->delete(route('free-text.destroy', ['id' => $test->id]))
            ->assertRedirect(route('free-text.index'));

        $this->actingAs($this->user)
            ->get('free-text')
            ->assertDontSeeText('example-name');

    }
}
