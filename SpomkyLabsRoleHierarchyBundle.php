<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2015 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace SpomkyLabs\RoleHierarchyBundle;

use SpomkyLabs\RoleHierarchyBundle\DependencyInjection\SpomkyLabsRoleHierarchyExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SpomkyLabsRoleHierarchyBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new SpomkyLabsRoleHierarchyExtension('spomkylabs_role_hierarchy');
    }
}
