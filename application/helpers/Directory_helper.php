<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// List of basic directory helper functions
// 1 - createDir          -- Creates directory id not exists
// 2 - deleteDir                  -- Deletes a directory if empty
// 3 - deleteFile                 -- Deletes a file
// 4 - renameFile                  -- Renames directory
// 5 - moveFile                   -- Moves file from one location to another location
// 6 - isDirEmpty                 -- Checks if a directory is empty or not
// 7 - truncateDir                -- Deletes all the contents of given directory
if ( ! function_exists('createDir') ){
	function createDir( $path ){
		if( $path ){
			if( !is_dir($path) ){
				return mkdir($path , 0755, true);
			}
		}else{
			return false;
		}
	}
}
if ( ! function_exists('moveFile') ){
	function moveFile( $sourcePath, $targetPath, $filename ){
		if( move_uploaded_file($sourcePath, APPPATH . '../' . $targetPath . '/' . $filename) ){
			return true;
		}else{
			return false;
		}
	}
}
if ( ! function_exists('renameFile') ){
	function renameFile( $oldPath = null, $newPath = null ){
		if( $oldPath && $newPath ){
			if( ( is_dir($oldPath) || is_file($oldPath) ) && is_writable($oldPath) ){
				$oldPath_arr = explode('/', trim($oldPath, '/'));
				$newPath_arr = explode('/', trim($newPath, '/'));
				array_pop($oldPath_arr);
				array_pop($newPath_arr);
				$oldPath_substr = implode('/', $oldPath_arr);
				$newPath_substr = implode('/', $newPath_arr);
				if( $oldPath_substr == $newPath_substr ){
					return rename($oldPath, $newPath);
				}else{
					// echo "Base paths must be same for both directories";
					return false;
				}
			}else{
				// echo "Path " . $oldPath . " does not exists";
				return false;
			}
		}else{
			// echo "oldPath and newPath parameters missing";
			return false;
		}
	}
}
if ( ! function_exists('isDirEmpty') ){
	function isDirEmpty( $path ){
		$files = array ();
	    if( is_dir($path) && is_readable($path) && !empty($path) ){
	    	$handle = opendir($path);
		    if ($handle){
		        while ( false !== ( $file = readdir ( $handle ) ) ) {
		            if ( $file != "." && $file != ".." )
		                $files[] = $file;
		            if(count($files) >= 1)
		                break;
		        }
		        closedir ($handle);
		    }
		    return ( count ( $files ) > 0 ) ? FALSE: TRUE;
	    }else{
	    	return false;
	    }
	}
}
if ( ! function_exists('truncateDir') ){
	function truncateDir( $path ){
		if( is_dir($path) && is_writable($path) && !empty($path) ){
			if( !isDirEmpty($path) ){
				$files = array_values(array_diff(scandir($path), array('.', '..')));
				foreach ($files as $key => $value) {
					$filepath = trim($path, '/') . '/' . $value;
					if( is_file($filepath) ){
						unlink($filepath);
					}else if( is_dir($filepath) ){
						if( isDirEmpty($filepath) ){
							rmdir($filepath);
						}else{
							truncateDir($filepath);
							rmdir($filepath);
						}
					}
				}
				return true;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
}
if ( ! function_exists('deleteDir') ){
	function deleteDir( $path = null){
		if( !empty($path) ){
			if( is_dir($path) ){
				if( isDirEmpty($path) && is_writable($path) ){
					rmdir($path);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
}
if ( ! function_exists('deleteFile') ){
	function deleteFile( $filePath = null ){
		if( !empty($filePath) ){
			if( is_file($filePath) && is_writable($filePath) ){
				unlink($filePath);
			}else{
				return false;
			}
		}
	}
}

if ( ! function_exists('dirToArray') ){
	function dirToArray($dir) {
	    $result = array();
	    $cdir = scandir($dir);
	    foreach ($cdir as $key => $value){
	      	if (!in_array($value,array(".",".."))){
	         	if (is_dir($dir . DIRECTORY_SEPARATOR . $value)){
	            	$result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
	         	}else{
	            	$result[] = $value;
	         	}
	      	}
	   	}
	   	return $result;
	}
}