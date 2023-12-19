<?php

namespace MiroClipboard\Enums;

enum LineCap: int
{
    case None           = 0;
    case Arrow          = 9;
    case Arrowhead      = 1;
    case ArrowThin      = 7;
    case TriangleFiled  = 8;
    case Triangle       = 6;
    case DiamondFilled  = 3;
    case Diamond        = 2;
    case CircleFilled   = 5;
    case Circle         = 4;
    case Bar            = 10;
    case CrowFoot       = 11;
    case BarCrowFoot    = 14;
    case BarBar         = 12;
    case CircleCrowFoot = 15;
    case CircleBar      = 13;

}
