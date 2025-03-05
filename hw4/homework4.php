<?php
    /**
     * Homework 4 - PHP Introduction
     *
     * Computing ID: djx3rn
     * Resources used: https://www.php.net/manual/en/langref.php
     */
     
    // Your functions here

    // No closing php tag needed since there is only PHP in this file
    function calculateAverage($scores, $drop = false) {
        /** 
         * It is indexed by nums, but they contain arrays themselves
         * $scores = [ [ "score" => 55, "max_points" => 100 ], [ "score" => 55, "max_points" => 100 ] ];
         * 
         * true means drop the lowest project score and 
         * false means do not drop any scores. 
         * 
         * The lowest score is determined based on percentage of points awarded
         * (for example, a 55/100 is 55% while a 7/10 is 70%, so the 55/100 is dropped).
         * 
         * If there are multiple lowest project scores (i.e., same percentages), you decide which one to drop
         * 
         * The function must return the overall average of the project scores
         * (100 * total scored points / total available points) rounded to three decimal places.
        */

        // 1 remove the array with the lowest percentage or 2 do some math to remove the lowest percentage

        $lowest = 0;
        $lowest_score = 0;
        $lowest_max = 0;
        $total_score = 0;
        $total_max = 0;
        
        foreach ($scores as $score) {
            $total_score += $score["score"];
            $total_max += $score["max_points"];
            $percent = $score["score"] / $score["max_points"];
            if ($percent < $lowest) {
                $lowest = $percent;
                $lowest_score = $score["score"];
                $lowest_max = $score["max_points"];
            }
        }
        
        if ($drop) {
            $total_score -= $lowest_score;
            $total_max -= $lowest_max;
        }

        return round(100 * $total_score / $total_max, 3);
    }
    
    function gridCorners($width, $height) {
        /**
         * The function gridCorners should return a comma-separated string that represents all unique tiles 
         * that are in the corner “brackets”, in numerical order. 
         * A “bracket” is defined as the corner tile and its adjacent neighbors. 
         */

         // Maybe something like a four corners approach
         // I know the corners are 0, 0; 0, height; width, 0; width, height
         // (0, 0)'s Neighbor would be (0, 1) and (1, 0)
         // (0, height)'s Neighbor would be (0, height - 1) and (1, height)
         // (width, 0)'s Neighbor would be (width, 1) and (width - 1, 0)
         // (width, height)'s Neighbor would be (width, height - 1) and (width - 1, height)
         // But, can't make a 2D array, so you need to add as you iterate the for-loop
        $num = 1;
        $output = [];
        for($i=0;$i<$width;$i++){
            for($j=0;$j<$height;$j++){
                echo "($i, $j): $num\n";
                // 4 corners
                if ($i == 0 || $i == $width - 1) {
                    if ($j == 0 || $j == $height - 1) {
                        $output[] = $num;
                    }
                }
                // (0,0) neighbors
                if  ($i == 0 && $j == 1) {
                    $output[] = $num;
                }
                if  ($i == 1 && $j == 0) {
                    $output[] = $num;
                }

                // (0, height) neighbors
                if  ($i == 0 && $j == $height - 2) {
                    $output[] = $num;
                }
                if  ($i == 1 && $j == $height - 1) {
                    $output[] = $num;
                }

                // (width, 0) neighbors
                if  ($i == $width - 2 && $j == 1) {
                    $output[] = $num;
                }
                if  ($i == $width - 1 && $j == 0) {
                    $output[] = $num;
                }

                // (width, height) neighbors
                if  ($i == $width - 2 && $j == $height - 1) {
                    $output[] = $num;
                }
                if  ($i == $width - 1 && $j == $height - 2) {
                    $output[] = $num;
                }

                $num++;
            }
        }

        // php has nice functions
        $output = array_unique($output);
        return implode(",", $output);
    }
    function combineShoppingLists($list1, $list2){
        $merged = [];
        foreach ($list1["list"] as $item) {
            $merged[$item] = [$list1["user"]];
        }
        foreach ($list2["list"] as $item) {
            if (array_key_exists($item, $merged)) {
                $merged[$item][] = $list2["user"];
            } else {
                $merged[$item] = [$list2["user"]];
            }
        }
        return var_dump($merged);
    }

    function acronymSummary($acronyms, $searchString){
        /**
         * Write a PHP function named acronymSummary() that calculates and returns an “acronym summary” of a given string. 
         * The “acronym summary” is calculated by finding how many times each of the possible words 
         * in the first string parameter are acronyms used in the second string parameter. 
         * Note: the acronym summary is case insensitive.
         */

        if (strlen($acronyms) == 0 || strlen($searchString) == 0) {
            return [];
        }

        $acronym_array = explode(" ", $acronyms);
        $output = [];
        foreach ($acronym_array as $acronym) {
            $output[$acronym] = 0;
        }
        foreach ($acronym_array as $acronym) {
            $acronym_index = 0;
            $searchString = strtolower($searchString);
            foreach (explode(" ", $searchString) as $word) {
                if (strtolower($word[0]) == strtolower($acronym[$acronym_index])) {
                    $acronym_index++;
                    if ($acronym_index == strlen($acronym)) {
                        if (array_key_exists($acronym, $output)) {
                            $output[$acronym]++;
                        } else {
                            $output[$acronym] = 1;
                        }
                        $acronym_index = 0;
                    }
                }
            }
        }
        return var_dump($output);
    }
?>