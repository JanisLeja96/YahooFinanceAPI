<?php
?>

<html>
<body>
<a href="/">Back</a>

<?php if (isset($error)):?>
<?php echo "<h2>{$error}</h2>";?>
<?php endif;?>

<div style="font-size: 1.5em">
    <?php echo "<h2>{$company->getName()}, {$company->getSymbol()}</h2>";?><br>
    <?php echo "Currency: {$company->getCurrency()}";?><br>
    <?php echo 'Current price: ' . $company->getPrice();?><br>
    <?php echo 'Open: ' . $company->getOpen();?><br>
    <?php echo 'Bid: ' . $company->getBid();?><br>
    <?php echo 'Ask: ' . $company->getAsk();?><br>
    <?php echo 'Day\'s range: ' . $company->getDaysRange();?><br>
    <?php echo '52 week range: ' . $company->getYearRange();?><br>
    <?php echo 'Volume: ' . $company->getFormattedVolume();?><br>
    <?php echo 'Average volume: ' . $company->getFormattedAverageVolume();?><br>
    <?php echo 'Market cap: ' . $company->getFormattedMarketCap();?><br>
</div>
<div style="margin-top: 20px">
    <?php echo "This data was last updated at {$company->getLastUpdated()}";?>
</div>


</body>
</html>
