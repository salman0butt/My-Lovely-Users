<?php

declare(strict_types=1);

namespace Inpsyde\MyLovelyUsers\Interfaces;

interface SettingInterface
{
    public function register(): void;
    public function SettingsPage(): void;
    public function display(): void;
    public function save(): void;
}
