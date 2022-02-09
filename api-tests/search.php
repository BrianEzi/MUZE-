<?php include_once "../api/doSearch.php"; ?>
<?php if (isset($_GET["searchTerm"])) { ?>
    <style>
        .inline-list {
            overflow-x: auto;
            display: flex;
            list-style-type: none;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        .inline-list li {
            display: inline-block;
            padding: 1rem;
        }
        .inline-list li h1 {
            width: 20vw;
            text-overflow: ellipsis;
            overflow: hidden;
        }
        .inline-list li img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
        }
    </style>

    <?php $types = array_filter(SPOTIFY_CONTENT_TYPE::$ALL, function($type) { return array_key_exists($type, $_GET); }); ?>
    <ul>
        <li>Search terms: <?=$_GET["searchTerm"]?></li>
        <li>
            Chosen content types:
            <?=implode(", ", $types);?>
        </li>
    </ul>

    <?php $results = doSearch($_GET["searchTerm"], $types); ?>

    <ul class="inline-list">
        <?php foreach ($results[SPOTIFY_CONTENT_TYPE::TRACK]->items as $result) { ?>
            <li>
                <img width="300" height="300" src="<?=$result->album->images[0]->url?>">
                <h1><?=$result->name?></h1>
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
