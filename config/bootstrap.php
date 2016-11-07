<?php
/**
 * This file is part of cakephp-mysql-backup.
 *
 * cakephp-mysql-backup is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * cakephp-mysql-backup is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with cakephp-mysql-backup.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author      Mirko Pagliai <mirko.pagliai@gmail.com>
 * @copyright   Copyright (c) 2016, Mirko Pagliai for Nova Atlantis Ltd
 * @license     http://www.gnu.org/licenses/agpl.txt AGPL License
 * @link        http://git.novatlantis.it Nova Atlantis Ltd
 */

use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Cake\Network\Exception\InternalErrorException;

//Database connection
if (!Configure::check('MysqlBackup.connection')) {
    Configure::write('MysqlBackup.connection', 'default');
}

//Default backups directory
if (!Configure::check('MysqlBackup.target')) {
    Configure::write('MysqlBackup.target', TMP . 'backups');
}

//Checks for connection
$connection = Configure::read('MysqlBackup.connection');

if (empty(ConnectionManager::config($connection))) {
    throw new InternalErrorException(__d('mysql_backup', 'Invalid `{0}` connection', $connection));
}

if (!is_writeable(Configure::read('MysqlBackup.target'))) {
    trigger_error(sprintf('Directory %s not writeable', Configure::read('MysqlBackup.target')), E_USER_ERROR);
}
