<?php

namespace App\Core\Project\Tests\Feature\Builder;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Vo\NameVo;
use App\Core\Project\Infrastructure\Models\Project as ProjectModel;
use App\Core\Shared\Infrastructure\Models\Years;

class ProjectSUT
{
    public ?Project $project;

    public ?ProjectModel $dbProject;

    public Years $year;

    public static function asSUT(): static
    {
        $static = new static;
        $static->year = Years::factory()->create();
        $static->project = null;
        $static->dbProject = null;

        return $static;
    }

    public function withExistingProject(): static
    {
        $this->project = Project::create(
            id: '001', name: new NameVo('Projet 1'), slug: 'project-1', description: 'titre du projet 1'
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
        ProjectModel::factory()->count($nbProjects)->create([
            'year_id' => $this->year->id,
        ]);

        return $this;
    }
}
