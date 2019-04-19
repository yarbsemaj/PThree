<?php

namespace Tests\Feature\TestSerise;

use App\Test;
use App\TestSeries;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ManageTest extends TestCase
{

    private $user;

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory('App\User')->create();
    }

    public function test_series_create()
    {
        $this
            ->actingAs($this->user)
            ->post(route('test-series.store'),
                ['name' => 'test series example', 'description' => 'description',
                    'consent_form' => UploadedFile::fake()->create('form.pdf')])
            ->assertRedirect(route('test-series.index'));

        $this->actingAs($this->user)
            ->get(route('test-series.index'))
            ->assertSee('test series example');
    }

    public function test_series_add_tests()
    {
        $this
            ->actingAs($this->user)
            ->post(route('test-series.store'),
                ['name' => 'test-series-example', 'description' => 'description',
                    'consent_form' => UploadedFile::fake()->create('form.pdf')])
            ->assertRedirect(route('test-series.index'));

        $testSeries = TestSeries::where('name', 'test-series-example')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->post(route('free-text.store'),
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect('free-text');

        $test = Test::where('name', 'example-name')->where('user_id', $this->user->id)->first();

        $this->actingAs($this->user)
            ->get(route('test-series.setup-test', ['id' => $testSeries->id]))
            ->assertSeeTextInOrder(['Test not yet used', 'example-name']);

        $this->actingAs($this->user)
            ->post(route('test-series.setup-test-save', ['id' => $testSeries->id]),
                ['name' => [$test->id]])
            ->assertRedirect(route('test-series.index'));

        $this->actingAs($this->user)
            ->get(route('test-series.setup-test', ['id' => $testSeries->id]))
            ->assertSeeTextInOrder(['example-name', 'Test not yet used']);

    }


    public function test_series_add_tests_user_not_test_owner()
    {
        $this
            ->actingAs($this->user)
            ->post(route('test-series.store'),
                ['name' => 'test-series-example', 'description' => 'description',
                    'consent_form' => UploadedFile::fake()->create('form.pdf')])
            ->assertRedirect(route('test-series.index'));

        $testSeries = TestSeries::where('name', 'test-series-example')->where('user_id', $this->user->id)->first();

        $otherUser = factory('App\User')->create();

        $this->actingAs($otherUser)
            ->post(route('free-text.store'),
                ['name' => 'example-name', 'description' => 'example-description'])
            ->assertRedirect('free-text');

        $test = Test::where('name', 'example-name')->where('user_id', $otherUser->id)->first();

        $this->actingAs($this->user)
            ->get(route('test-series.setup-test', ['id' => $testSeries->id]))
            ->assertDontSee('example-name');

        $this->actingAs($this->user)
            ->post(route('test-series.setup-test-save', ['id' => $testSeries->id]),
                ['name' => [$test->id]])
            ->assertRedirect(route('test-series.setup-test', ['id' => $testSeries->id]));

        $this->actingAs($this->user)
            ->get(route('test-series.setup-test', ['id' => $testSeries->id]))
            ->assertDontSee('example-name');

    }
}
