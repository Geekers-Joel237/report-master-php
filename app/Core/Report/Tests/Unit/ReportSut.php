<?php

namespace App\Core\Report\Tests\Unit;

use App\Core\Project\Domain\Entities\Project;
use App\Core\Project\Domain\Vo\NameVo;

class ReportSut
{
    public Project $project;

    public static function asSUT(): static
    {
        return new static;
    }

    public function withProject(): static
    {
        $this->project = Project::create(
            id: '001',
            name: new NameVo('my-project-name'),
            slug: 'my-project-name'
        );

        return $this;
    }

    public function build(): static
    {
        return $this;
    }
}
