<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {

        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    function a_user_has_accessibale_projects()
    {
        $john = $this->singIN();
        $project = ProjectFactory::ownedBy($john)->create();
        $this->assertCount(1,$john->accessibleProjects());

        $sally = factory(User::class)->create();
        $nick = factory(User::class)->create();

        $sallyProject = ProjectFactory::ownedBy($sally)->create();
        $sallyProject->invite($nick);

        $this->assertCount(1,$john->accessibleProjects());

        $sallyProject->invite($john);

        $this->assertCount(2,$john->accessibleProjects());


    }
}
