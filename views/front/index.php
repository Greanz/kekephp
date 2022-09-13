<?php
echo "Hello Am index i can be also called as /home, Am also defined in configuration.json file";
echo "<p><b>Menu</b></p>";

echo "<ul>";
    echo "<li><a href='home/method2'>Method 2</a></li>";
    echo "<li><a href='home/method3/1'>Method 3 with Get Id 1</a></li>";
    echo "<li><a href='home/method3'>Method 3 no Get value defined, I will raise error if you remove Id</a></li>";
    echo "<li><a href='home/methodWithView'>Am the view with everything</a></li>";
    echo "<li><a href='home/methodWithView'>Am the view with everything, I will not raise error when you remove Id</a></li>";
    echo "</ul>";