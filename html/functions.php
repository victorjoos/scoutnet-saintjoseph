<?php
date_default_timezone_set("Europe/Brussels");
function exists($file) {
    $dir = 'news';
    $files = scandir($dir);
    return in_array($file, $files);
}

/**
 * Documents
 */

function listFiles($dir) {
    return scandir($dir);
}

function fileExtension($file) {
        return pathinfo($file, PATHINFO_EXTENSION);
}

function makeRow($file, $extension) {
    $filename = str_replace("_", " ", $file);
    return "<tr><td class=\"clickableRow\" data-link=\"row\"><img src=\"mime/pdf.png\" alt=\"file\" /></td><td><a href=\"documents/$file\">$filename</a></td></tr>";
}

function makeRows($files) {
    $rows = "";
    foreach ($files as $file) {
        $extension = fileExtension($file);
        if ($extension != "") {
            $row = makeRow($file, $extension);
            $rows = "{$rows}{$row}\n";
        }
    }
    return $rows;
}

/**
 * END Documents
 */

/**
 * Events
 */

function compare_events($a, $b) {
  if ($a["start"]==$b["start"]) {
    return 0;
  }
  return ($a["start"] < $b["start"]) ? -1 : 1;
}

function makeEventRows($events, $type=false) {
    usort($events,"compare_events");
    $day = array("dimanche","lundi","mardi","mercredi","jeudi","vendredi","samedi");
    if ($type) {
        $rows ="";
        foreach ($events as $event) {
            $start = date("d/m/Y",$event["start"]/1000);
            $end = date("d/m/Y",$event["end"]/1000);
            $start_day = $day[date("w",$event["start"]/1000)];
            $end_day = $day[date("w",$event["end"]/1000)];
            if ($start != $end) {
                $date = "Du {$start_day} {$start} au {$end_day} {$end}";
            } else {
                $date = "Le {$start_day} {$start}";
            }
            $row = "<tr><td>{$event["title"]}</td><td>$date</td><td>Toutes sections</td></tr>";
            $rows = "{$rows}{$row}\n";
        }
    }
    else {
        $rows ="";
        foreach ($events as $event) {
            $start = date("Y-m-d H:i",$event["start"]/1000);
            $end = date("Y-m-d H:i",$event["end"]/1000);
            $row = "<tr><td>{$event["id"]}</td><td><a href=\"?id={$event["id"]}\">{$event["title"]}</a></td><td>{$start}</td><td>{$end}</td></tr>";
            $rows = "{$rows}{$row}\n";
        }
    }
    return $rows;
}

function addEvent($data) {
    $json = file_get_contents('events.json');
    $json_array = json_decode($json, true);
    $events = $json_array["result"];
    if (($start = strtotime($data["start"])) === false) {
        return false;
    }
    if (($end = strtotime($data["end"])) === false) {
        return false;
    }
    $events[$data["id"]] = array("id" => $data["id"],
                      "title" => htmlspecialchars($data["name"]),
                      "url" => "",
                      "class" => "event-success",
                      "start" => $start*1000,
                      "end" => $end*1000);
    $json_array["result"] = $events;
    $new_json = json_encode($json_array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    file_put_contents('events.json',$new_json);
    return true;
}

function deleteEvent($id) {
    $json = file_get_contents('events.json');
    $json_array = json_decode($json, true);
    $events = $json_array["result"];
}

function getEvent($id) {
    $json = file_get_contents('events.json');
    $json_array = json_decode($json, true);
    $events = $json_array["result"];
    $id_event = array("id" => $events[sizeof($events)-1]["id"]+1);
    foreach ($events as $event) {
        if ($event["id"] == $id) {
            $id_event = $event;
            break;
        }
    }
    return $id_event;
}

/**
 * END Events
 */

/**
 * Photos
 */

function make_photo_index() {
  $dir = "photos";
  $json_file = "photos.json";
  $array = array("modified" => 0);
  $subdir = scandir($dir);
  $albums = array();
  $n=0;
  foreach($subdir as $album) {
    if ($album[0] != '.') {
      $albums[$n] = array("directory" => $album, "photos" => array(), "modified" => 0, "paragraph" => "");
      $pictures  = scandir($dir.'/'.$album);
      $m=0;
      foreach($pictures as $picture) {
        if ($picture[0] != '.') {
          $albums[$n]["photos"][$m]["file"] = $picture;
          $albums[$n]["photos"][$m]["title"] = "";
          $m =  $m+1;
        }
      }
      $n = $n+1;
    }
  }
  $array["albums"] = $albums;
  $json = json_encode($array, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
  $result = file_put_contents($json_file, $json);
  return $array;
}

function make_image_gallery() {
  $json = file_get_contents('photos.json');
  $array = json_decode($json, true);
  if ($array["modified"] != 0) {
    $array = make_photo_index();
  }
  $albums = $array["albums"];
  $gallery = "";
  foreach($albums as $album) {
    $title = str_replace("_"," ",$album["directory"]);
    $gallery =  "{$gallery}<div class=\"jumbotron\"><div class=\"container\">
                    <h2>{$title}</h2>
                    <p>{$album["paragraph"]}</p>
                 </div></div>";
    $gallery = "{$gallery}<div class=\"container\"><div class=\"row\">\n";
    $n=1;
    foreach($album["photos"] as $photo) {
      $row = "<div class=\"col-sm-6 col-md-4\">
                <a href=\"photos/{$album["directory"]}/{$photo["file"]}\" data-gallery>
                  <img src=\"photos/{$album["directory"]}/{$photo["file"]}\" class=\"img-responsive img-thumbnail\" alt=\"\" />
                </a>
              </div>";
      if ($n % 3 == 0) {
        $row = "{$row}<div class=\"clearfix hidden-sm\"></div>";
      }
      $gallery = "{$gallery}{$row}\n";
      $n = $n+1;
    }
    $gallery .= "</div></div>";
  }
  return $gallery;
}

/**
 * END Photos
 */
