/**
 * PHP zip
 */
class Zip
{
    
   /**
    * 单文件压缩成一个 zip 包
    * @param string file 被压缩文件[磁盘路径]  D:/alg/test.txt
    * @param string zipPath 压缩路径[磁盘路径] D:/alg/test.zip
    */
   PUBLIC function zipSingleFile($file, $zipPath)
   {
      $zip = new \ZipArchive();
   
      //打开压缩包,没有则创建
      $zip->open($zipPath, \ZIPARCHIVE::CREATE);   
   
      //参数1是要压缩的文件,参数2为压缩后,在压缩包中的文件名
      $zip->addFile($file, basename($file)); 
      
      //关闭压缩包
      $rs = $zip->close();
   }

   /**
    * 多文件压缩成一个 zip 包
    * @param array fileList 被压缩文件[磁盘路径]  D:/alg/test.txt
    * @param string zipPath 压缩路径[磁盘路径] D:/alg/test.zip
    */
   PUBLIC function zipMultiFile($fileList, $zipPath)
   {
      $zip = new \ZipArchive();
      
      //打开压缩包,没有则创建
      $zip->open($zipPath, \ZIPARCHIVE::CREATE);   

      foreach($fileList as $filePath)
      {
         $zip->addFile($filePath, str_replace(dirname($zipPath).'/', '', $filePath));
      }

      //关闭压缩包
      $rs = $zip->close();
   }

   /**
    * 文件夹压缩成一个 zip 包
    * @param array fileList 被压缩文件[磁盘路径]  D:/alg/test/
    * @param string zipPath 压缩路径[磁盘路径] D:/alg/test.zip
    */
   PUBLIC function zipDirectory($dirPath, $zipPath)
   {
      $zip = new \ZipArchive();
     
      //打开压缩包,没有则创建
      $zip->open($zipPath, \ZIPARCHIVE::CREATE);
     
      //获取该文件夹所有文件列表
      $datalist= self::list_dir($dirPath); 
      
      //创建压缩文件
      foreach($datalist as $filePath)
      {
         if(file_exists($filePath))
         {
            //注:第二个参数是放在压缩包中的文件名称，直接将文件的相对路径作为文件的包内名称，然后就惊喜的发现zip包内文件夹出现了
            $zip->addFile($filePath, str_replace($dirPath.'/', '', $filePath));
         }
      }

      //关闭
      $zip->close();
   }

   //获取文件列表
   PUBLIC static function list_dir($dir)
   { 
      $result = [];
      if (is_dir($dir))
      {
         $file_dir = scandir($dir);
         foreach($file_dir as $file)
         {
            if ($file == '.' || $file == '..'){
               continue;
            } 
            elseif (is_dir($dir.'/'.$file)){ 
               $result = array_merge($result, self::list_dir($dir.'/'.$file));
            }
            else{ 
               array_push($result, $dir.'/'.$file);
            }
         }
      }
      return $result;
   }
}
