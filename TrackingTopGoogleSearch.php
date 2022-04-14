<form action="">
    <label for="keyword">Keyword: </label>
    <input type="text" id="keyword" name="keyword" value="<?= $_GET['keyword'] ?>"><br><br>
    <label for="domain">Domain: </label>
    <input type="text" id="domain" name="domain" value="<?= $_GET['domain'] ?>"><br><br>
    <label for="topsearch">Top Search: </label>
    <input type="text" id="topsearch" name="topsearch" value="<?= $_GET['topsearch'] ?>"><br><br>
    <input type="submit" value="Submit">
</form>

<?php
require_once("simple_html_dom.php");
$starttime = microtime(true);

if (!empty($_GET['keyword']) && !empty($_GET['domain'])) {
    $input_keyword = $_GET['keyword'];
    $input_domain = $_GET['domain'];
    $input_topsearch = ($_GET['topsearch'] == '') ? 50 : $_GET['topsearch'];
    echo '-------------------------------------------<br>';

    $indexRank = 0;
    $outputRank = 0;
    $searchUrl = 'https://www.google.co.in/search?q=' . urlencode($input_keyword) . '&ie=utf-8&oe=utf-8&start=';

    echo '<strong> Tool Tracking Top Google Search By Domain </strong><br>';
    echo '-------------------------------------------<br>';
    echo 'Keyword: ' . $input_keyword . "<br>";
    echo 'Domain: ' . $input_domain . "<br>";
    echo 'Top search: ' . $input_topsearch . "<br>";

    for ($i = 0; $i < ($input_topsearch / 10); $i++) {
        $htmlData = file_get_html($searchUrl . ($i * 10));
        foreach ($htmlData->find('a') as $element) {
            $linkTopSearch = $element->href;

            if (strpos($linkTopSearch, 'url?') !== false) {
                if (isset($element->children(0)->innertext)) {
                    $innertext = $element->children(0)->innertext;

                    if (strpos($innertext, '<div') !== false) {
                        $indexRank = $indexRank + 1;

                        if (strpos($linkTopSearch, $input_domain) !== false) {
                            $outputRank = $indexRank;
                            echo 'Result: Top ' . $outputRank . "<br>";
                            $endtime = microtime(true);
                            echo 'Time tracking: ' . round($endtime - $starttime, 2) . ' second(s)';
                            exit;
                        }
                    }
                }
            }
        }
    }

    echo 'Result: Out of Top Search<br>';
    $endtime = microtime(true);
    echo 'Time tracking: ' . round($endtime - $starttime, 2) . ' second(s)';
    exit;
}
?>
