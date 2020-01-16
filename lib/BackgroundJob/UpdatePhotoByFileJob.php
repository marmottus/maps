<?php

/**
 * Nextcloud - maps
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Julien Veyssier
 * @copyright Julien Veyssier 2019
 */

namespace OCA\Maps\BackgroundJob;

use \OCP\BackgroundJob\QueuedJob;
use \OCP\BackgroundJob\IJobList;
use \OCP\AppFramework\Utility\ITimeFactory;
use OCP\IUserManager;
use OCP\IConfig;

use OCA\Maps\Service\PhotofilesService;


class UpdatePhotoByFileJob extends QueuedJob {

    private $jobList;

    /**
     * UserInstallScanJob constructor.
     *
     * A QueuedJob to scan user storage for photos and tracks
     *
     * @param IJobList $jobList
     */
    public function __construct(ITimeFactory $timeFactory,
                                PhotofilesService $photofilesService) {
        parent::__construct($timeFactory);
        $this->photofilesService = $photofilesService;
    }

    public function run($arguments) {
        $userFolder = $this->root->getUserFolder($arguments['userId']);
        $file = $userFolder->getById($arguments['fileId'])[0];
        if ($file !== null)
            $this->photofilesService->updateByFileNow($file);
    }
}
