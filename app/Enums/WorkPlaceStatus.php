<?php
namespace App\Enums;

enum WorkPlaceStatus: string
{
    case Open               = 'open';
    case Closed             = 'closed';
    case Shutdown           = 'shutdown';
    case UnderMaintenance   = 'under_maintenance';
    case UnderConstruction  = 'under_construction';
}