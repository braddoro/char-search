<?php
$dbhost = 'localhost';
$dbuser = 'brad';
$dbpass = 'alvahugh1';
$schema = 'bd7rbk520';

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!'  . '<br />' . '<br />';
} else {
    echo 'Phew we have it!' . '<br />' . '<br />';
}
// die('aaaaaaaaaa');
$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$schema);
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$files = array();
// $basePath = '/home/brad/Apps/gcs/gcs-4.11.1/Library/';
$basePath = 'gcs';

$item = 0;
$files[$item]['fileName'] = "/Skills/Action.skl";
$files[$item]['xpath'] = 'skill';

$item++;
$files[$item]['fileName'] = "/Skills/Action.skl";
$files[$item]['xpath'] = 'technique';

$item++;
$files[$item]['fileName'] = "/Skills/Basic Set.skl";
$files[$item]['xpath'] = 'skill';

$item++;
$files[$item]['fileName'] = "/Skills/Basic Set.skl";
$files[$item]['xpath'] = 'technique';

$item++;
$files[$item]['fileName'] = "/Skills/High Tech.skl";
$files[$item]['xpath'] = 'skill';

$item++;
$files[$item]['fileName'] = "/Skills/High Tech.skl";
$files[$item]['xpath'] = 'technique';

$item++;
$files[$item]['fileName'] = "/Skills/Martial Arts.skl";
$files[$item]['xpath'] = 'skill';

$item++;
$files[$item]['fileName'] = "/Skills/Martial Arts.skl";
$files[$item]['xpath'] = 'technique';

$item++;
$files[$item]['fileName'] = "/Skills/Psionics.skl";
$files[$item]['xpath'] = 'skill';

$item++;
$files[$item]['fileName'] = "/Skills/Psionics.skl";
$files[$item]['xpath'] = 'technique';

// //
// $item++;
$files[$item]['fileName'] = "/Advantages/Basic Set.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/High Tech.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Ultra Tech.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Action.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Martial Arts.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Psionics.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Dungeon Fantasy.adq";
$files[$item]['xpath'] = 'advantage';

$item++;
$files[$item]['fileName'] = "/Advantages/Power Ups.adq";
$files[$item]['xpath'] = 'advantage';

//
$item++;
$files[$item]['fileName'] = "/Equipment/Basic Set.eqp";
$files[$item]['xpath'] = 'equipment';

$item++;
$files[$item]['fileName'] = "/Equipment/High Tech.eqp";
$files[$item]['xpath'] = 'equipment';

$item++;
$files[$item]['fileName'] = "/Equipment/Ultra Tech.eqp";
$files[$item]['xpath'] = 'equipment';

$item++;
$files[$item]['fileName'] = "/Equipment/Action.eqp";
$files[$item]['xpath'] = 'equipment';

$item++;
$files[$item]['fileName'] = "/Equipment/Magic.eqp";
$files[$item]['xpath'] = 'equipment';

$item++;
$files[$item]['fileName'] = "/Equipment/Dungeon Fantasy.eqp";
$files[$item]['xpath'] = 'equipment';

foreach($files as $file){
  $file['fileName'] = $basePath . $file['fileName'];
  if(file_exists($file['fileName'])){
    loadData($file, $mysqli);
  }else{
    echo("Unable to locate file: " . $file['fileName'] . "<br/>");
  }
}

function loadData($file, $mysqli){
    $fileName = $file['fileName'];
    $xpath = $file['xpath'];
    $source = basename($fileName);

    echo('Loading: ' . $source . " Class: " . $xpath . "<br/>");

    $xml=simplexml_load_file($fileName) or die("Error: Cannot create object");
    $result = $xml->xpath($xpath);
    $oloop=0;
    while(list( , $node) = each($result)) {
        $itemID=NULL;
        $class=ucwords($xpath);
        $item_name=NULL;
        $specialization=NULL;
        $canonical_name=NULL;
        $points=NULL;
        $reference=NULL;
        $difficulty=NULL;
        $type=NULL;
        $base_points=NULL;
        $quantity=NULL;
        $tech_level=NULL;
        $legality_class=NULL;
        $value=NULL;
        $notes=NULL;
        $levels=NULL;
        $cr=NULL;
        $points_per_level=NULL;
        $weight=NULL;
        $long_description=NULL;

        if(isset($node->xpath("name")[0])) {
            $item_name = addslashes($node->xpath("name")[0]) . "";
        }
        $newName = str_replace("'", "`",$item_name);
        $newName = str_replace('"', "`",$newName);
        $newName = str_replace("-", "_",$newName);
        $newName = str_replace(",", "_",$newName);
        $newName = str_replace(";", "_",$newName);
        $newName = str_replace(":", "_",$newName);
        $newName = str_replace("/", "_",$newName);
        $newName = str_replace(".", "_",$newName);
        $newName = str_replace("'", "_",$newName);
        $newName = str_replace("(", "_",$newName);
        $newName = str_replace(")", "_",$newName);
        $newName = str_replace("@", "",$newName);
        $newName = str_replace(" ", "_",$newName);
        $newName = str_replace("__", "_",$newName);

        if(substr($newName, -1) == '_'){
          $newName = substr_replace($newName,"",-1);
        }
        $canonical_name = $newName;

        if(isset($node->xpath("specialization")[0])) {
            $specialization = addslashes($node->xpath("specialization")[0]) . "";
        }

        if(isset($node->xpath("difficulty")[0])) {
            $difficulty = $node->xpath("difficulty")[0] . "";
        }
        if(isset($node->xpath("points")[0])) {
            $points = $node->xpath("points")[0] . "";
        }
        if(isset($node->xpath("reference")[0])) {
            $reference = $node->xpath("reference")[0] . "";
        }
        if(isset($node->xpath("type")[0])) {
            $type = $node->xpath("type")[0] . "";
        }
        if(isset($node->xpath("base_points")[0])) {
            $base_points = $node->xpath("base_points")[0] . "";
        }
        if(isset($node->xpath("quantity")[0])) {
            $quantity = $node->xpath("quantity")[0] . "";
        }
        if(isset($node->xpath("legality_class")[0])) {
            $legality_class = $node->xpath("legality_class")[0] . "";
        }
        if(isset($node->xpath("value")[0])) {
            $value = $node->xpath("value")[0] . "";
        }
        if(isset($node->xpath("cr")[0])) {
            $cr = $node->xpath("cr")[0] . "";
        }
        if(isset($node->xpath("levels")[0])) {
            $levels = $node->xpath("levels")[0] . "";
        }
        if(isset($node->xpath("points_per_level")[0])) {
            $points_per_level = $node->xpath("points_per_level")[0] . "";
        }
        if(isset($node->xpath("weight")[0])) {
            $weight = $node->xpath("weight")[0] . "";
        }

        if(isset($node->xpath("description")[0])) {
            $description = addslashes($node->xpath("description")[0]) . "";
        }
        if(isset($node->xpath("notes")[0])) {
            $notes = addslashes($node->xpath("notes")[0]) . "";
        }

        // Equipment name is not stored in the name column but it is for me.
        //
        if($item_name == ""){
            $item_name = $description;
        }

        // Make this import different.
        $item_name = $item_name . '';

        $sql  = "INSERT INTO gurps.items2 (class,item_name,source,specialization,canonical_name,points,reference,difficulty,type,base_points,quantity,tech_level,legality_class,value,notes,levels,cr,points_per_level,weight,long_description) ";
        $sql .= "VALUES ('$class','$item_name','$source','$specialization','$canonical_name','$points','$reference','$difficulty','$type','$base_points','$quantity','$tech_level','$legality_class','$value','$notes','$levels','$cr','$points_per_level','$weight','$long_description')";
        if (!$mysqli->query($sql)) {
            echo("$sql" . '<br />');
            echo($mysqli->error . '<br />');
        }else{
            //printf ("New Record has id %d.\n", $mysqli->insert_id);
            $itemID = $mysqli->insert_id;
        }

        // Defaults
        //
        if(!is_null($itemID)){
            if(count($node->xpath("default")) > 0) {
                foreach($node->xpath("default") as $item) {
                    $def_type=NULL;
                    $def_name=NULL;
                    $def_modi=NULL;
                    $def_spec=NULL;
                    if(isset($item->xpath("type")[0])) {
                        $def_type = $item->xpath("type")[0] . "";
                    }
                    if(isset($item->xpath("name")[0])) {
                        $def_name = addslashes($item->xpath("name")[0]) . "";
                    }
                    if(isset($item->xpath("modifier")[0])) {
                        $def_modi = $item->xpath("modifier")[0] . "";
                    }
                    if(isset($item->xpath("specialization")[0])) {
                        $def_spec = addslashes($item->xpath("specialization")[0]) . "";
                    }
                    $sql  = "INSERT INTO gurps.defaults2 (itemID_fk,type,name,modifier,specialization) ";
                    $sql .= "VALUES ($itemID,'$def_type','$def_name','$def_modi','$def_spec')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }
        }

        // Categories
        //
        if(!is_null($itemID)){
            if(count($node->xpath("categories")) > 0) {
                foreach($node->xpath("categories") as $item) {
                    $cat_category=NULL;
                    if(isset($item->xpath("category")[0])) {
                        $cat_category = $item->xpath("category")[0] . "";
                    }
                    $sql  = "INSERT INTO gurps.categories2 (itemID_fk,category) ";
                    $sql .= "VALUES ($itemID,'$cat_category')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }
        }


        // Advantage modifiers.
        //
        if(!is_null($itemID)){
            if(count($node->xpath("modifier")) > 0) {
                foreach($node->xpath("modifier") as $item) {
                    $mod_name=NULL;
                    $mod_affects=NULL;
                    $mod_reference=NULL;
                    $mod_notes=NULL;
                    if(isset($item->xpath("name")[0])) {
                        $mod_name = addslashes($item->xpath("name")[0]) . "";
                    }
                    if(isset($item->xpath("affects")[0])) {
                        $mod_affects = $item->xpath("affects")[0] . "";
                    }
                    if(isset($item->xpath("reference")[0])) {
                        $mod_reference = $item->xpath("reference")[0] . "";
                    }
                    if(isset($item->xpath("notes")[0])) {
                        $mod_notes = addslashes($item->xpath("notes")[0]) . "";
                    }
                    $sql  = "INSERT INTO gurps.modifiers2 (itemID_fk,name,affects,reference,notes) ";
                    $sql .= "VALUES ($itemID,'$mod_name','$mod_affects','$mod_reference','$mod_notes')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }
        }

        // Bonuses.
        //
        if(!is_null($itemID)){
            if(count($node->xpath("dr_bonus")) > 0) {
                foreach($node->xpath("dr_bonus") as $item) {
                    $bon_class='DR';
                    $bon_name=NULL;
                    $bon_amount=NULL;
                    if(isset($item->xpath("location")[0])) {
                        $bon_name = addslashes($item->xpath("location")[0]) . "";
                    }
                    if(isset($item->xpath("amount")[0])) {
                        $bon_amount = $item->xpath("amount")[0] . "";
                    }
                    $sql  = "INSERT INTO gurps.bonuses2 (itemID_fk,class,name,amount) ";
                    $sql .= "VALUES ($itemID,'$bon_class','$bon_name','$bon_amount')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }

            if(count($node->xpath("skill_bonus")) > 0) {
                foreach($node->xpath("skill_bonus") as $item) {
                    $bon_class='Skill';
                    $bon_name=NULL;
                    $bon_spec=NULL;
                    $bon_amount=NULL;
                    if(isset($item->xpath("name")[0])) {
                        $bon_name = addslashes($item->xpath("name")[0]) . "";
                    }
                    if(isset($item->xpath("specialization")[0])) {
                        $bon_spec = addslashes($item->xpath("specialization")[0]) . "";
                    }
                    if(isset($item->xpath("amount")[0])) {
                        $bon_amount = $item->xpath("amount")[0] . "";
                    }
                    $sql  = "INSERT INTO gurps.bonuses2 (itemID_fk,class,name,specialization,amount) ";
                    $sql .= "VALUES ($itemID,'$bon_class','$bon_name','$bon_spec','$bon_amount')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }
            if(count($node->xpath("attribute_bonus")) > 0) {
                foreach($node->xpath("attribute_bonus") as $item) {
                    $bon_class='Attribute';
                    $bon_attribute=NULL;
                    $bon_amount=NULL;
                    if(isset($item->xpath("attribute")[0])) {
                        $bon_attribute = addslashes($item->xpath("attribute")[0]) . "";
                    }
                    if(isset($item->xpath("amount")[0])) {
                        $bon_amount = $item->xpath("amount")[0] . "";
                    }
                    $sql  = "INSERT INTO gurps.bonuses2 (itemID_fk,class,attribute,amount) ";
                    $sql .= "VALUES ($itemID,'$bon_class','$bon_attribute','$bon_amount')";
                    if (!$mysqli->query($sql)) {
                        echo("$sql" . '<br />');
                        echo($mysqli->error . '<br />');
                    }
                }
            }
        }

        /*
        // How to get attributes.
        //
        //$foo = $name->xpath("specialization")[0]["compare"][0];


        <when_tl compare="at least">5</when_tl>
        <attribute_prereq has="yes" which="dx" compare="at least">12</attribute_prereq>

        <skill_prereq has="yes">
          <name compare="is">mathematics</name>
          <specialization compare="is">applied</specialization>
          <level compare="at least">14</level>
        </skill_prereq>
        <advantage_prereq has="yes">
          <name compare="is">trained by a master</name>
          <notes compare="is anything"></notes>
        </advantage_prereq>

        <prereq_list all="yes">
        	<skill_prereq has="yes">
        		<name compare="is">meditation</name>
        		<specialization compare="is anything"></specialization>
        	</skill_prereq>
        	<skill_prereq has="yes">
        		<name compare="is">breath control</name>
        		<specialization compare="is anything"></specialization>
        	</skill_prereq>
        	<advantage_prereq has="yes">
        		<name compare="is">trained by a master</name>
        		<notes compare="is anything"></notes>
        	</advantage_prereq>
        </prereq_list>

          <name compare="is">mathematics</name>
          <specialization compare="is">applied</specialization>
          <level compare="at least">14</level>

        <attribute_prereq has="yes" which="dx" compare="at most">13</attribute_prereq>
        */

        // Prerequisite
        //
        if(!is_null($itemID)){
            if(count($node->xpath("prereq_list")) > 0) {
                foreach($node->xpath("prereq_list") as $item) {

                    if(isset($item->xpath("when_tl")[0])) {
                        $when_tl = $item->xpath("when_tl")[0] . "";
                        //echo("when_tl: $when_tl" . '<br />');
                    }
                    if(isset($item->xpath("attribute_prereq")[0])) {
                        $attribute_prereq = $item->xpath("attribute_prereq")[0] . "";
                        //echo("attribute_prereq: $attribute_prereq" . '<br />');
                    }

                    foreach($item->advantage_prereq as $name){
                        $pre_class='Advantage';
                        $pre_name=NULL;
                        $def_notes=NULL;
                        $pre_spec=NULL;
                        $pre_level=NULL;
                        if(isset($name->xpath("name")[0])) {
                            $pre_name = $name->xpath("name")[0] . "";
                        }
                        if(isset($name->xpath("notes")[0])) {
                            $pre_notes = $name->xpath("notes")[0] . "";
                        }
                        $sql  = "INSERT INTO gurps.prerequisites2 (itemID_fk,class,name,notes,specialization,level) ";
                        $sql .= "VALUES ($itemID,'$pre_class','$pre_name','$pre_notes','$pre_spec','$pre_level')";
                        if (!$mysqli->query($sql)) {
                            echo("$sql" . '<br />');
                            echo($mysqli->error . '<br />');
                        }
                    }

                    foreach($item->skill_prereq as $name){
                        $pre_class='Skill';
                        $pre_name=NULL;
                        $pre_notes=NULL;
                        $pre_spec=NULL;
                        $pre_level=NULL;
                        if(isset($name->xpath("name")[0])) {
                            $pre_name = $name->xpath("name")[0] . "";
                        }
                        if(isset($name->xpath("notes")[0])) {
                            $pre_notes = $name->xpath("notes")[0] . "";
                        }
                        if(isset($name->xpath("specialization")[0])) {
                            $pre_spec = $name->xpath("specialization")[0] . "";
                        }
                        if(isset($name->xpath("level")[0])) {
                            $pre_level = $name->xpath("level")[0] . "";
                        }
                        $sql  = "INSERT INTO gurps.prerequisites2 (itemID_fk,class,name,notes,specialization,level) ";
                        $sql .= "VALUES ($itemID,'$pre_class','$pre_name','$pre_notes','$pre_spec','$pre_level')";
                        if (!$mysqli->query($sql)) {
                            echo("$sql" . '<br />');
                            echo($mysqli->error . '<br />');
                        }
                    }
                }
            }
        }
        $oloop++;
    }
    echo("Loaded Items: $oloop" . "<br/>");
}
$mysqli->close();
?>
