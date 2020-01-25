<?php


class MetalArchivesClient{

  const APIEND = 'https://api.outlawdesigns.io:8690/';
  const ARTISTEND = 'artist/';
  const ALBUMEND = 'album/';
  const LABELEND = 'label/';
  const SONGEND = 'song/';
  const LYRICEND = 'lyrics/';
  const DISCOGEND = 'discography/';
  const RECOMEND = 'recommendation/';
  const ROSTEREND = 'roster/';
  const SPACEPATT = '/\s/';
  const SPACEREPL = '%20';


  public function __construct(){
  }
  protected function _apiGet($uri){
   $ch = curl_init();
   curl_setopt($ch,CURLOPT_URL,self::APIEND . $uri);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
   $output = json_decode(curl_exec($ch));
   curl_close($ch);
   if(isset($output->error)){
     throw new \Exception($output->error);
   }
   return $output;
 }
 public function searchArtist($artist,$id = null){
   $artist = preg_replace(self::SPACEPATT,self::SPACEREPL,$artist);
   $uri = self::ARTISTEND . (is_null($id) ? $artist:$artist . '' . $id);
   return $this->_apiGet($uri);
 }
 public function searchAlbum($album,$artist = null,$albumId = null){
   $album = preg_replace(self::SPACEPATT,self::SPACEREPL,$album);
   $artist = preg_replace(self::SPACEPATT,self::SPACEREPL,$artist);
   $uri = self::ALBUMEND . (is_null($artist) ? $album:$album . '' . $artist) . (is_null($albumId) ? '/':$albumId);
   return $this->_apiGet($uri);
 }
 public function searchLabel($label){
   return $this->_apiGet(self::LABELEND . preg_replace(self::SPACEPATT,self::SPACEREPL,$label));
 }
 public function searchSong($title){
   return $this->_apiGet(self::SONGEND . preg_replace(self::SPACEPATT,self::SPACEREPL,$title));
 }
 public function getLyrics($songId){
   return $this->_apiGet(self::LYRICEND . $songId);
 }
 public function getDiscography($artistId){
   return $this->_apiGet(self::DISCOGEND . $artistId);
 }
 public function getRecommendations($artistId){
   return $this->_apiGet(self::RECOMEND . $artistId);
 }
 public function getRoster($labelId,$past = null){
   $uri = self::ROSTEREND . $labelId . (is_null($past) ? '':'true');
   return $this->_apiGet($uri);
 }
}
