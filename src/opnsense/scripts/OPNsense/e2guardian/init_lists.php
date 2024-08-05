<?php

require_once('config.inc');
use OPNsense\Core\Config;
use OPNsense\e2guardian\Clist;


function getDirectories($path)
{
    return glob(rtrim($path, '/') . '/*', GLOB_ONLYDIR);
}
function validateString($str) {
    $pattern = '/^([ ]*<.+>(;<.+>)?<(-)?[1-9]+0*>[ ]*(#.*)?)$/';
    return preg_match($pattern, $str);
}

function parse_files()
{
    $basePath = '/usr/local/etc/e2guardian/lists/phraselists/';
    $filename = 'weighted';
    $parsed = [];

    foreach (getDirectories($basePath) as $languageDir) {
        foreach (getDirectories($languageDir) as $categoryDir) {
            $filePath = $categoryDir . '/' . $filename;
            if (file_exists($filePath)) {
                $fileContent = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

                if ($fileContent !== false) {
                    $visiblename = '';
                    $rules = [];

                    foreach ($fileContent as $line) {
                        if (empty($visiblename) && preg_match('/"(.+)"/u', $line, $matches)) {
                            $visiblename = $matches[1];
                            continue;
                        }
                        if (strpos(trim($line), '#') === 0) {
                            continue;
                        }

                        $line = str_replace(',', ';', trim($line));

                        if (validateString($line)) {
                            $rules[] = $line;
                        }
                    }

                    $rules = implode(',', $rules);

                    $list = [
                        'listname' => basename($languageDir) . ' - ' . basename($categoryDir),
                        'visiblename' => $visiblename,
                        'rules' => $rules
                    ];
                    if ($rules && $visiblename && $rules){
                        $parsed[] = $list;
                    }
                }
            }
        }
    }

    return $parsed;
}

function clistExists($listname)
{
    $config = Config::getInstance()->object();
    if (!empty($config->OPNsense->e2guardian->clist->clists)) {
        foreach ($config->OPNsense->e2guardian->clist->clists->children() as $configNode) {
            if ((string)$configNode->listname[0] === $listname) {
                return true;
            }
        }
    }
    return false;
}

function save_to_model($data)
{
    $model = new Clist();
    foreach ($data as $list) {
        if (!clistExists($list['listname'])) {
            $clist = $model->clists->clist->add();
            $clist->listname = $list['listname'];
            $clist->visiblename = $list['visiblename'];
            $clist->listtype = 'weightedphraselist';
            $clist->weightedphrasefield = $list['rules'];
        }
    }
    $model->serializeToConfig();
    Config::getInstance()->save();
}

$phraselists = parse_files();
save_to_model($phraselists);

