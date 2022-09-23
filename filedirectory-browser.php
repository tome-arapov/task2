<?php
function dir_tree($dir_path, $olderThan, $youngerThan)
{
    $rdi = new RecursiveDirectoryIterator($dir_path);

    $rii = new RecursiveIteratorIterator($rdi);

    $tree = [];

    foreach ($rii as $splFileInfo) {
        $file_name = $splFileInfo->getFilename();
        $type = $splFileInfo->getType();
        $file = $splFileInfo->getPathname();
        $extension = $splFileInfo->getExtension();
        $basename = $splFileInfo->getBasename();
        $timestamp = $splFileInfo->getMTime();
        $date_modified = date('D F j, Y, g:i a',$timestamp);
        $size = $splFileInfo->getSize();

        if ($file_name[0] === '.') {
            continue;
        }
        if ($timestamp > $olderThan && $timestamp < $youngerThan) {

            $path = $splFileInfo->isDir() ? array($file_name => array()) : array(array('filename' => $file_name,'type' => $type,'file' => $file,'file_ext' => $extension,'basename_file' => $basename,'last_modified_t' => $timestamp,'last_modified' => $date_modified,'file_size' => $size.' B'));

            
            for ($depth = $rii->getDepth() - 1; $depth >= 0; $depth--) {

                $path = array($rii->getSubIterator($depth)->current()->getFilename() => $path);

            }    

            $tree = array_merge_recursive($tree, $path);

        }

    }

    return $tree;
}

echo '<pre>';
echo json_encode(dir_tree('C:\xampp\htdocs\OOP',1663278674,
1663969874
));
