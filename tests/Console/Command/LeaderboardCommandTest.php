<?php

declare(strict_types=1);

namespace App\Tests\Console\Command;

use App\Console\Command\LeaderboardCommand;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class LeaderboardCommandTest extends WebTestCase
{
    /** @test */
    public function it_generates_a_leaderboard_of_speakers(): void
    {
        $command = $this->getContainer()->get(LeaderboardCommand::class);
        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $this->assertSame(0, $commandTester->getStatusCode());

        $display = $commandTester->getDisplay();
        $this->assertStringContainsString('Speaker name', $display);
        $this->assertStringContainsString('Number of talks', $display);
        $this->assertRegExp('/Oliver Davies\s+1/', $display);
    }

    /** @test */
    public function it_displays_a_summary_of_speaker_and_talk_counts(): void
    {
        $command = $this->getContainer()->get(LeaderboardCommand::class);
        $commandTester = new CommandTester($command);

        $commandTester->execute([]);

        $this->assertStringContainsString('[INFO] 1 talks from 1 speakers.', $commandTester->getDisplay());
    }

    private function getContainer(): ContainerInterface
    {
        $this->bootKernel();

        return self::$container;
    }
}
