<!DOCTYPE html>

<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" href="./css/index.css">
        <title>Задание 12 мoдуля</title>
    </head>
    <body>
    <?php
        $example_persons_array = [
            [
                'fullname' => 'Иванов Иван Иванович',
                'job' => 'tester',
            ],
            [
                'fullname' => 'Степанова Наталья Степановна',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Пащенко Владимир Александрович',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Громов Александр Иванович',
                'job' => 'fullstack-developer',
            ],
            [
                'fullname' => 'Славин Семён Сергеевич',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Цой Владимир Антонович',
                'job' => 'frontend-developer',
            ],
            [
                'fullname' => 'Быстрая Юлия Сергеевна',
                'job' => 'PR-manager',
            ],
            [
                'fullname' => 'Шматко Антонина Сергеевна',
                'job' => 'HR-manager',
            ],
            [
                'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
                'job' => 'analyst',
            ],
            [
                'fullname' => 'Бардо Жаклин Фёдоровна',
                'job' => 'android-developer',
            ],
            [
                'fullname' => 'Шварцнегер Арнольд Густавович',
                'job' => 'babysitter',
            ],
        ];

        echo "<h1>Разбиение и объединение ФИО</h1>";

        function getPartsFromFullname($fullname) {

            $name = explode(" ", $fullname);
            $array1 = ["surname"=>$name[0], "name"=>$name[1], "patronymic"=>$name[2]];
            return $array1;
        };

        function getFullnameFromParts($surname, $name, $patronymic) {
            return $surname . ' ' . $name . ' ' . $patronymic;
        
        }

        function getShortName($fullname) {
            $array2 = getPartsFromFullname($fullname);
            $name = $array2['name'];
            $surname = mb_substr($array2['surname'], 0, 1);
            return $name . ' ' . $surname . '.';
        
        }

        function getGenderFromName($fullname) {
            $array3 = getPartsFromFullname($fullname);
            $gender = 0;
            if (mb_substr($array3['patronymic'], -2) == 'ич') {
                $gender++;
            }
            if (mb_substr($array3['name'], -1) == 'й' || mb_substr($array3['name'], -1) == 'н') {
                $gender++;
            }
            if (mb_substr($array3['surname'], -1) == 'в') {
                $gender++;
            }
            if (mb_substr($array3['surname'], -2) == 'ва') {
                $gender--;
            }
            if (mb_substr($array3['name'], -1) == 'а') {
                $gender--;
            }
            if (mb_substr($array3['patronymic'], -3) == 'вна') {
                $gender--;
            }
            return ($gender > 0) <=> ($gender <0);
        }

        function getGenderDescription($example_persons_array) {
            $array4 = array_filter($example_persons_array, function($person) {
                $gender = getGenderFromName($person['fullname']);
                if ($gender > 0) {
                    return true;
                }        
            });
            $array5 = array_filter($example_persons_array, function($person) {
                $gender = getGenderFromName($person['fullname']);
                if ($gender < 0) {
                    return true;
                }        
            });
            $array6 = array_filter($example_persons_array, function($person) {
                $gender = getGenderFromName($person['fullname']);
                if ($gender == 0) {
                    return true;
                }        
            });
            $genderLenght = count($example_persons_array);
            echo "<h1>Гендерный состав аудитории в %:</h1><br/>";
            echo "Мужчины - " . round(count($array4)/$genderLenght * 100, 1);
            echo "<br/>Женщины - " . round(count($array5)/$genderLenght * 100, 1);
            echo "<br/>Не удалось определить - " . round(count($array6)/$genderLenght * 100, 1);
        }

        getGenderDescription($example_persons_array);

        function getPerfectPartner($surname, $name, $patronymic, $example_persons_array) {
            $surname = mb_convert_case($surname, MB_CASE_TITLE);
            $name = mb_convert_case($name, MB_CASE_TITLE);
            $patronymic = mb_convert_case($patronymic, MB_CASE_TITLE);

            $fullname = getFullnameFromParts($surname, $name, $patronymic);

            $gender1  = getGenderFromName($fullname);

            $people_key = array_rand($example_persons_array);
            $people = $example_persons_array[$people_key]; 

            $gender2 = getGenderFromName($people['fullname']);
        
            $array8 = getPartsFromFullname($fullname);
            var_dump($gender1);
            var_dump($gender2);
            var_dump($fullname);

            while ($gender1 == $gender2) {
                $people_key = array_rand($example_persons_array);
                $people = $example_persons_array[$people_key]; 

                $gender2 = getGenderFromName($people['fullname']);
            }  
            $a = random_int(50, 100);
            echo $name . ' ' . $surname . '.' . $name . ' ' . $surname . ". = Идеально на {$a}% <br>";
            return $people;     
        
        }

        $person = $example_persons_array[0]; 
        echo "<br>"; #Просто для разрыва 
        echo "<h1>Идеальный подбор пары</h1>"; 
        echo "<br>"; #Просто для разрыва 

        foreach($example_persons_array as $person) {
            if(is_array($person['fullname'])) {
                continue;
            }
            
            $array7 = getPartsFromFullname($person['fullname']);
            $surname = $array7['surname'];
            $name = $array7['name'];
            $patronymic = $array7['patronymic'];
            getPerfectPartner($surname, $name, $patronymic, $example_persons_array);  
        
        }      
    ?>  
    </body>
</html>
