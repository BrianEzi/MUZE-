<?php include_once "../api/doSearch.php"; ?>
<?php if (isset($_GET["searchTerm"])) { ?>
    <?php $types = array_filter(SPOTIFY_CONTENT_TYPE::$ALL, function($type) { return array_key_exists($type, $_GET); }); ?>
    <ul>
        <li>Search terms: <?=$_GET["searchTerm"]?></li>
        <li>
            Chosen content types:
            <?=implode(", ", $types);?>
        </li>
    </ul>

    <?php $results = doSearch($_GET["searchTerm"], $types); ?>

    <ul>
        <?php foreach ($results[SPOTIFY_CONTENT_TYPE::TRACK]->items as $result) { ?>
            <li>
                <h1><?=$result->name?></h1>
                <img width="300" height="300" src="<?=$result->album->images[0]->url?>">
            </li>
        <?php } ?>
    </ul>

<?php } else { ?>

    <form action="search.php">
        <label>
            <input name="searchTerm" placeholder="Search terms">
        </label>
        <div>
            Content types:
            <?php foreach (SPOTIFY_CONTENT_TYPE::$ALL as $type) { ?>
                <label>
                    <input type="checkbox" name="<?=$type?>">
                    <?=$type?>
                </label>
                &nbsp;
                &nbsp;
            <?php } ?>
        </div>

        <button type="submit">Search</button>
    </form>
<?php } ?>
