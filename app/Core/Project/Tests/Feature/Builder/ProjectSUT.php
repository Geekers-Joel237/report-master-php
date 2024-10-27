<?php

namespace App\Core\Project\Tests\Feature\Builder;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;

class ProjectSUT
{
    public ?Project $project;

    public ?ProjectModel $dbProject;

    public static function asSUT(): static
    {
        $static = new static;
        $static->project = null;
        $static->dbProject = null;

        return $static;
    }

    public function withExistingProject(): static
    {
        $this->project = Project::create(
            id: '001', name: new NameVo('Projet 1'), description: 'titre du projet 1'
        );

        return $this;
    }

    public function build(): static
    {
        return $this;
    }

    public function withDbExistingProject(): static
    {
        $this->dbProject = ProjectModel::factory()->create();

        return $this;
    }

    public function withExistingProjects(int $nbProjects): static
    {
        ProjectModel::factory()->count($nbProjects)->create();
        return $this;
    }
}
