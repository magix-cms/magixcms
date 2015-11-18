<?php
# -- BEGIN LICENSE BLOCK ----------------------------------
#
# This file is part of magix cjQuery.
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# Magix cjQuery is a library written in PHP 5.
# It can work with a layer of abstraction, to validate data, handle jQuery code in PHP.
# Copyright (C)Magix cjQuery 2009 Gerits Aurelien
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as
# published by the Free Software Foundation, either version 3 of the
# License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# -- END LICENSE BLOCK -----------------------------------
/**
 * 
 * Magix cjQuery
 * 
 * @author Gérits Aurélien
 * @access public
 * @copyright clashdesign
 * @version 0.1
 * @package Files and Dir
 *
 */
class magixcjquery_files_makefiles{
	/**
	 * @scan dir recursive file
	 *
	 * @param array $dir
	 * @param bool $sort
	 * @return array()
	 */
	/*public function scanDir($dir=array(),$sort=1){
		
		$isdir = new SplFileInfo($dir);
		/*check is dir*/
		/*if (!$isdir->isDir($dir)) {
			
			throw new Exception(sprintf(__('%s is not a directory.'),$dir));
			exit();
		}
		$dirs = array_diff( scandir($dir,$sort), array( ".", ".." ));
		$dir_array = array();
		    foreach( $dirs as $d ){
		        if( is_dir($dir."/".$d) ){ 
		        	$dir_array[ $d ] = scanDir($dir."/".$d);
		        }
		        else {
		        	$dir_array[ $d ] = $d;
		        } 
		    }
		$obj = new ArrayObject($dir_array);
		$it = $obj->getIterator();
		/*** check if valid ***/
		/*$it->valid();
		/*** move to the next array member ***/
		/*$it->next();
		//$obj->count();
		//$it .= $count?iterator_count($obj):false;
	    /*return $it;
	}*/
	/**
	 * scans the directory and returns all files
	 * @param string $directory
	 * @param string exclude
	 */
	public function scanDir($directory,$exclude=''){
		try{
			$file = null;
			$it = new DirectoryIterator($directory);
			for($it->rewind(); $it->valid(); $it->next()) {
		        if(!$it->isDir() && !$it->isDot() && $it->isFile()){
		      		/*if($it->getFilename() == $exclude) continue;
		      		$file[] = $it->getFilename();*/
                    if(is_array($exclude)){
                        if(!in_array($it->getFilename(), $exclude)){
                            $file[] = $it->getFilename();
                        }
                    }else{
                        if($it->getFilename() == $exclude) continue;
                        $file[] = $it->getFilename();
                    }
                }
	   		}
	   		return $file;
		}catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = M_TMP_DIR;
	        $log->write('An error has occured', $e->getMessage(), $e->getLine());
	        die("Failed scanDir"); 
		}
	}
	/**
	 * scan folders recursive and returns all folders
	 * @param string $directory
	 * @param string exclude
	 */
	public function scanRecursiveDir($directory,$exclude=''){
		try{
			$file = '';
			$it = new DirectoryIterator($directory);
			for($it->rewind(); $it->valid(); $it->next()) {
		       if($it->isDir() && !$it->isDot()){
		       		if($it->getFilename() == $exclude) continue;
	         		$file[] = $it->getFilename();
	      		}
	   		}
			return $file;
		}catch(Exception $e) {
			$log = magixcjquery_error_log::getLog();
	        $log->logfile = M_TMP_DIR;
	        $log->write('An error has occured', $e->getMessage(), $e->getLine());
	        die("Failed scan folders recursive"); 
		}
	}
	/**
	 * scans the folder and returns all folders and files
	 * @param string $directory
	 */
	public function scanRecursiveDirectoryFile($directory){
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::SELF_FIRST);
		foreach($objects as $name => $object){
		    $dir[] .= $object->getFilename();
		}
		return $dir;
	}
	public function dirFilterIterator($directory){
		$directories = new AppendIterator () ;
		$directories->append (new RecursiveIteratorIterator (new RecursiveDirectoryIterator ($directory)));
		//$directories->append (new RecursiveIteratorIterator (new RecursiveDirectoryIterator ('/autre_repertoire/')));
		$itFiles = new ExtensionFilterIteratorDecorator($directories);
		$itFiles->setExtension ('.phtml');
		foreach ( $itFiles as $Item )  {
		   //applique le traitement à $Item
		   return $t[] = $Item;
		}
	}
	/*
	 * @Search recursively for a file in a given directory
	 *
	 * @param string $filename The file to find
	 *
	 * @param string $directory The directory to search
	 *
	 * @return bool
	 *
	 */
	public function recursiveFileExists($filename, $directory){	
	    try
	    {
	        /*** loop through the files in directory ***/
	        foreach(new recursiveIteratorIterator( new recursiveDirectoryIterator($directory)) as $file)
	        {
	            /*** if the file is found ***/
	            if( $directory.DIRECTORY_SEPARATOR.$filename == $file )
	            {
	                return true;
	            }
	        }
	        /*** if the file is not found ***/
	        return false;
	    }
	    catch(Exception $e)
	    {
	        /*** if the directory does not exist or the directory
	            or a sub directory does not have sufficent
	            permissions return false ***/
	        throw new Exception(sprintf('%s is not permission.'),$file);
	        //return false;
	    }
	}
	/**
	 * erase Recursive file in multi dir
	 * @param string $directory
	 */
	public function removeRecursiveFile($directory,$debug=false){
		$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory), RecursiveIteratorIterator::SELF_FIRST);
		$dir = null;
		foreach($objects as $name => $object){
			if($object->isDir($name)) continue;
			if($debug == true){
				$dir[] .=  $name;
				magixcjquery_debug_magixfire::magixFireInfo($dir);
			}else{
				$dir[] .=  @unlink($name);
			}
		}
		return $dir;
	}
	/**
	 * Create new folder
	 *
	 * @param string $path path folder
	 * @param string $name name new folder
	 */
	public function createDir($path,$name){
		if(!self::recursiveFileExists($path,$path)==true){
			if (!file_exists($path.$name)) {
				$dir = new DirectoryIterator($path);
				if ($dir->isDir()) {
					//@umask(0);
					try{
						if(is_writable($path)){
							@mkdir($path.$name, 0777,true);
							//@chmod($path.$name,0777);
						}else{
							throw new Exception($path.' is not writable');
						}
					}catch(Exception $e) {
						$log = magixcjquery_error_log::getLog();
				        $log->logfile = M_TMP_DIR;
				        $log->write('An error has occured', $e->getMessage(), $e->getLine());
				        exit("Failed to create dir"); 
					}
				}
			}
		}
	}
	/**
	 * This function recursively deletes all files in a folder,
	 * without following symlinks
	 * 
	 * @param string $path path folder.
	 */
	public function removeDir($path) {
		if(!self::recursiveFileExists($path,$path)==true){
			if(is_dir($path)){
			    $dir = new DirectoryIterator($path);
			    foreach ($dir as $fileinfo){
			        if($fileinfo->isFile() || $fileinfo->isLink()){
			            @unlink($fileinfo->getPathName());
			        }elseif (!$fileinfo->isDot() && $fileinfo->isDir()) {
			            @rmdir($fileinfo->getPathName());
			      }
			   }
			   if(!self::recursiveFileExists($path,$path)==true){
			   	$info = new SplFileInfo($path);
				   @rmdir($info->getPathname());
			   }else{
			    	return false;
			   }
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	/**
	 * This function recursively deletes files in a folder,
	 * without following symlinks
	 * 
	 * @param string $path path folder.
	 * @param string $filename
	 */
	public function removeFile($path,$filename){
		if(is_dir($path)){
		    $dir = new DirectoryIterator($path);
		    foreach ($dir as $fileinfo) {
		        if ($fileinfo->isFile() || $fileinfo->isLink()) {
		        	if(!self::recursiveFileExists($filename,$path)==true){
		            	@unlink($path.$filename);
		        	}
		        }
		    }
		}else{
			return false;
		}
	}
	/**
	 * This function recursively rename folder,
	 * 
	 * @param string $path path folder.
	 * @param string $name name folder
	 * @param string $newname new name folder
	 */
	public function renameDir($path,$name,$newname) {	
		if(is_dir($path.$name)){
		    $dir = new DirectoryIterator($path.$name);
		    foreach ($dir as $fileinfo) {
		        if ($fileinfo->isDir()) {
		        	if (!self::recursiveFileExists($path.$name,$path.$name)==true) {
		        		rename($path.$name,$path.$newname);
		        	}
		        }
		    }
		}else{
			return false;
		}
	}
	/**
	 * This function rename files,
	 * 
	 * @param string $path path files.
	 * @param string $name name files
	 * @param string $newname new name files
	 */
	public function renameFiles($path,$name,$newname) {
		$info = new SplFileInfo(__FILE__);
		if($info->isFile()){
		     rename($name,$newname);
		     //$path.$name
		}else{
			throw new Exception("This file does not exist: can't rename file");
			return false;
		}
	}
	/**
	 * return size directory in bytes
	 * @param string $directory
	 */
	public function sizeDirectory($directory){
		try{
			$foldersize = 0;
			$dir = new sizeDirectory($directory);
			foreach($dir as $size) $foldersize += $size;
			return $foldersize.' bytes';
		}catch (Exception $e) {
			if (M_LOG == 'log') {
		        if (M_TMP_DIR != null) {
			        $log = magixcjquery_error_log::getLog();
			        $log->logfile = $_SERVER['DOCUMENT_ROOT'].M_TMP_DIR;
			        $log->write('An error has occured', $e->getMessage(), $e->getLine());
			        exit("Error has sizeDirectory, view log file");
			     }else{
			        die('error path tmp dir');
			     }
			 }elseif(M_LOG == 'debug'){
				print $e->getMessage(). $e->getLine()."<br />";
		     }else{
		        exit("Error has sizeDirectory, debug with log");	
		     }
		}
	}
    /**
    *
    * @recursively check if a value is in array
    *
    * @param string $string (needle)
    *
    * @param array $array (haystack)
    *
    * @param bool $type (optional)
    *
    * @return bool
    *
    */
    function in_array_recursive($string, $array, $type=false)
    {
        /*** an recursive iterator object ***/
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));

        /*** traverse the $iterator object ***/
        while($it->valid())
        {
            /*** check for a match ***/
            if( $type === false )
            {
                if( $it->current() == $string )
                {
                    return true;
                }
            }
            else
            {
                if( $it->current() === $string )
                {
                    return true;
                }
            }
            $it->next();
        }
        /*** if no match is found ***/
        return false;
    }
    /**
     * filterFiles => filter files with extension
     * $t = new magixcjquery_files_makefiles();
	 * var_dump($t->filterFiles('mydir',array('gif','png','jpe?g')));
	 * or
	 * var_dump($t->filterFiles('mydir','php'));
     * @param $dir
     * @param $extension
     */
    public function filterFiles($directory,$extension){
	    try {
		    $filterfiles = new filterFiles($directory,$extension);
			$filter = '';
		    foreach($filterfiles as $file) {
		        if(($file->isDot()) || ($file->isDir())) continue;
		        $filter[] .= $file;
		    }
		    return $filter;
		}catch (Exception $e) {
			if (M_LOG == 'log') {
		        if (M_TMP_DIR != null) {
			        $log = magixcjquery_error_log::getLog();
			        $log->logfile = $_SERVER['DOCUMENT_ROOT'].M_TMP_DIR;
			        $log->write('An error has occured', $e->getMessage(), $e->getLine());
			        exit("Error has filterFiles, view log file");
			     }else{
			        die('error path tmp dir');
			     }
			 }elseif(M_LOG == 'debug'){
				print $e->getMessage(). $e->getLine()."<br />";
		     }else{
		        exit("Error has filterFiles, debug with log");	
		     }
		}
    }
    /**
     * @create thumbnails
     *
     * @param string $source_image
     * @param string $directory
     * @param string $thumb_height
     * @param string $thumb_dir
     * @param string $thumb_prefix
     * @param string $quality
     * @return bool
     */
	public function createThumbnails($source_image,$directory,$thumb_height,$thumb_dir,$thumb_prefix,$quality){
		self::createDir($directory,$thumb_dir);
		if(!self::recursiveFileExists($source_image,false) == false)
	    {
	        return false;
	    }
	    else
	    {
	        /*** supported types ***/
	        $supported_types = array(1, 2, 3);
	
	        /*** get the image info ***/
	        list($width_orig, $height_orig, $image_type) = getimagesize($source_image);
	
	        /** check for supported type ***/
	         
	        if(!self::in_array_recursive($image_type, $supported_types, true))
	        {
	            return 'Unsupported Image Type: ' . $image_type;
	           //return false;
	        }
	        else
	        {
	            /*** get the filename ***/
	            $path_parts = pathinfo($source_image);
	            $filename = $path_parts['filename'];
	
	            /*** calculate the aspect ratio ***/
	            $aspect_ratio = (float) $width_orig / $height_orig;
	
	            /*** calulate the thumbnail width based on the height ***/
	            $thumb_width = round($thumb_height * $aspect_ratio);
	 
	            /*** imagecreatefromstring will automatically detect the file type ***/
	            $source = imagecreatefromstring(file_get_contents($source_image));
				
	            /*** create the thumbnail canvas ***/ 
	            $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	            /** create transparent */
				imagealphablending($thumb, false);
				imagesavealpha( $thumb, true );
	            /*** map the image to the thumbnail ***/
	            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width_orig, $height_orig);
	            /*** destroy the source ***/
	            imagedestroy($source);
	 
	            /*** write thumbnail based on file type ***/
	            switch ( $image_type )
	            {
	                case 1:
	                    $thumbnail = $directory.$thumb_dir.$thumb_prefix.$filename . '.gif';
	                    imagegif($thumb, $thumbnail);
	                    break;
	
	                case 2:
	                    $thumbnail = $directory.$thumb_dir.$thumb_prefix.$filename . '.jpg';
	                    imagejpeg($thumb, $thumbnail, $quality);
	                    break;
	
	                case 3:
	                    $thumbnail = $directory.$thumb_dir.$thumb_prefix.$filename . '.png';
	                    imagepng($thumb, $thumbnail);
	                    break;
	            }
	        }
	    }
	}
	/**
	 * function detect image type and convert image file in PNG
	 *
	 * @param string $filename
	 */
	public function convertPng($filename){
		if(file_exists($filename)){
			//Detect mimetype
			$filesize = getimagesize($filename);
			// if jpg mime
			if ($filesize['mime'] == "image/jpeg") {
				$type = '.jpg';
				$source = imagecreatefromjpeg($filename);
				$destination = imagecreatetruecolor($filesize[0], $filesize[1]);
				imagecopy($destination, $source, 0, 0, 0, 0, $filesize[0], $filesize[1]);
				imagedestroy($source);
				unlink($filename);
				$substr = strlen($type);
				imagepng($destination, substr($filename,0,-$substr).'.png');
			//if if gif mime
			}elseif ($filesize['mime'] == "image/gif") {
				$type = '.gif';
				$source = imagecreatefromgif($filename);
				$destination = imagecreatetruecolor($filesize[0], $filesize[1]);
				imagecopy($destination, $source, 0, 0, 0, 0, $filesize[0], $filesize[1]);
				imagedestroy($source);
				unlink($filename);
				$substr = strlen($type);
				imagepng($destination, substr($filename,0,-$substr).'.png');
			}
	    }
	}
	/**
	 * writing values in constants
	 * @param string $name
	 * @param void $val
	 * @param path construct $str
	 * Creates config.php file
		$full_conf = file_get_contents($config_in);
		writeConstValue('M_DBDRIVER',$M_DBDRIVER,$full_conf);
		writeConstValue('M_DBHOST',$M_DBHOST,$full_conf);
		writeConstValue('M_DBUSER',$M_DBUSER,$full_conf);
		writeConstValue('M_DBPASSWORD',$M_DBPASSWORD,$full_conf);
		writeConstValue('M_DBNAME',$M_DBNAME,$full_conf);
		writeConstValue('M_LOG',$M_LOG,$full_conf);
		writeConstValue('M_TMP_DIR',$M_TMP_DIR,$full_conf);
		writeConstValue('M_FIREPHP',$M_FIREPHP,$full_conf);
	 */
	public function writeConstValue($name,$val,&$str,$quote=true){
		if($quote){
			$quote = '$1,\''.$val.'\');';
		}else{
			$quote = '$1,'.$val.');';
		}
		$val = str_replace("'","\'",$val);
		$str = preg_replace('/(\''.$name.'\')(.*?)$/ms',$quote,$str);
	}
}
class filterFiles extends DirectoryIterator
{
    /**
     * String ou Array d'extensions de fichiers
     */
    protected $regexp;

    public function __construct($path,$extensions)
    {
        if(is_array($extensions)) {
            $this->regexp = '`\.('.implode('|',$extensions).')$`i';
        }
        else $this->regexp = '`\.('.$extensions.')$`i';

        //appel le constructeur parent
        parent::__construct($path);
    }

    /**
     * Vérifier l'extension d'un fichier
     */
    public function isExtensions()
    {
        if(!parent::isFile() or !preg_match($this->regexp, parent::getFilename())) {
           return false;
        }
        return true;
    }

    /**
     * Surcharge la méthode parent pour procéder à
     * la vérification de chacun des éléments pendant l'itération
     */
    public function valid()
    {
        if(parent::valid()) {
            if(parent::isFile()) {
               if(!$this->isExtensions()) {
                   parent::next();
                   return $this->valid();
               }
               else return true;
            }
            else return true;
        }
        return false;
    }
}
class sizeDirectory extends directoryIterator implements iterator
{
    public function current() {
        return parent::isFile() ? parent::getSize() : 0;
    }
}
class UserFilter extends FilterIterator
{
    private $userFilter;
   
    public function __construct(Iterator $iterator , $filter )
    {
        parent::__construct($iterator);
        $this->userFilter = $filter;
    }
   
    public function accept()
    {
        $user = $this->getInnerIterator()->current();
        if( strcasecmp($user['name'],$this->userFilter) == 0) {
            return false;
        }       
        return true;
    }
}
class ExtensionFilterIteratorDecorator extends FilterIterator {
   /**
    * extension actuellement filtrée
    *
    * @var string
    */
   private $_ext;
 
   /**
    * Indique si l'élément courant est accepté
    *
    * @return boolean
    */
   public function accept (){
      if (substr ($this->current (), -1 * strlen ($this->_ext)) === $this->_ext){
         return is_readable ($this->current ());
      }
      return false;
   }
 
   /**
    * Définition de l'extension sur laquelle on veut filtrer les données.
    *
    * @param string $pExt
    */
   public function setExtension ($pExt){
      $this->_ext = $pExt;
   }
}