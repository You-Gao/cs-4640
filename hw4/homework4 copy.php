<?php
    /**
     * Homework 4 - PHP Introduction
     *
     * Computing ID: djx3rn
     * Resources used: https://www.php.net/manual/en/langref.php
     */
     
    // Your functions here

    // No closing php tag needed since there is only PHP in this file
    function calculateGrade($scores, $drop = false) {
        if (count($scores) == 0) {
            return 0;
        }

        $lowest = 100;
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
        $output = [];
        if ($width == 0 || $height == 0) {
            return implode(", ", $output);
        }
        if ($width == 1 && $height == 1) {
            $output[] = 1;
            return implode(", ", $output);
        }
        if ($width == 1) {
            $output[] = 1; 
            $output[] = $height;
            return implode(", ", $output);
        }
        $output[] = 1; 
        $output[] = $height; 
        $output[] = $width * $height - $height + 1;
        $output[] = $width * $height; 

        // bottom left neighbors
        if ($height > 1) {
            $output[] = 2;
        }
        if ($width > 1) {
            $output[] = $height + 1;
        }

        // top left neighbors
        if ($height > 1) {
            $output[] = $height - 1;
        }
        if ($width > 1) {
            $output[] = 2 * $height;
        }

        // bottom right neighbors
        if ($height > 1) {
            $output[] = $width * $height - $height;
        }
        if ($width > 1) {
            $output[] = $width * $height - $height + 2;
        }

        // top right neighbors
        if ($height > 1) {
            $output[] = $width * $height - 1;
        }
        if ($width > 1) {
            $output[] = $width * $height - $height;
        }
        // php has nice functions
        $output = array_unique($output);
        sort($output);
        return implode(", ", $output);
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
        return sort($merged);
    }

    function acronymSummary($acronyms, $searchString){

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
        return $output;
    }