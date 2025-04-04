<?php
// background for pie chart - i.e.:
// background: conic-gradient(rgb(68, 44, 1) 0 50%, rgb(176, 84, 113) 0 75%,  rgb(176, 84, 113) 0)
// '0' after rgb() 0 makes edges sharp and percentage determines filling ratio
$background = 'background: conic-gradient(';
$i = 0;
foreach ($records as &$record)  // pass elements by reference with & operator as it is modified in loop
{
  // add comma after every item excluding the last one (e.g. before every item beside first one)
  if ($i > 0) $background = $background . ', ';

  // get different color for every category - i.e.: rgb(68, 44, 1)
  $color = '';
  $hash = md5($record['category']);
  // get consecutive 2 chars from hash -> convert from hex to dec -> use as a consecutive RGB coordinates
  for ($j = 0; $j <= 4; $j += 2) {
    $color = $color . (string)(hexdec(substr($hash, $j, 2)));
    if ($j < 4) $color = $color . ', '; // add comma after every item exluding the last one
  }
  $color = 'rgb(' . $color . ')';

  // save color for chart legend
  $record['color'] = $color;

  // add color, '0' (for sharp edges) and percentage to background style
  $background = $background . $color . ' 0 ' . ($record['running_category_sum'] / $sum * 100) . '%';
  $i++;
}
$background = $background . ')';

// Break the reference with the last element.
// For the rationale behind this see the manual ->
// https://www.php.net/manual/en/control-structures.foreach.php (warning section)
unset($record);

// get padding for chart legend 
define("pieChartHeight", 450);  // value set in main.css - if changed, both pieChartHeight and css value must be changed
define("maxElementsCountInColumn", 16);
$legendColumnsCount = ceil(count($records) / (maxElementsCountInColumn));
// equal number of elements in every column would be displayed
// e.g. if there are 17 elements, in first column there would be 9 items, and in the second one - 8 items
$elementsOnColumnCount = ceil(count($records) / $legendColumnsCount);
$proportionOfFreeSpaceInLegendColumn = 1 - $elementsOnColumnCount / maxElementsCountInColumn;
$pixelsOfFreeSpaceInLegendColumn = pieChartHeight * $proportionOfFreeSpaceInLegendColumn;
$legendPaddingTop = $pixelsOfFreeSpaceInLegendColumn / 2;
$paddingStyle = 'style="padding-top:' . $legendPaddingTop . 'px;"' ?>

<div class="chart">
  <div class="pie_chart" style="<?php echo $background ?>"></div>

  <?php
  //display legend
  $i = 0;
  foreach ($records as $record):
    if ($i % $elementsOnColumnCount == 0):

      // if new legend column (but not the first one) is starting then close last div and open new legend column
      if ($i > 0)
        echo '</div>';

      // check if element is in last legend column to set proper margin-right (see legend_last_column in main.css)
      $lastLegendColumnStyle = ($i >= (($legendColumnsCount - 1) * $elementsOnColumnCount)) ? 'legend_last_column' : '' ?>
      <div class="legend <?php echo $lastLegendColumnStyle ?>" <?php echo $paddingStyle ?>>
      <?php endif ?>

      <?php
      $expensePercentage = round($record['category_sum'] / $sum * 100, 0);
      $expenseLabel = $record['category'] . ' ' . $expensePercentage . '%' ?>
      <div class="legend_item">
        <div class="item_color" style="background-color: <?php echo $record['color']; ?>"></div>
        <div class="item_text"><?php echo $expenseLabel ?></div>
      </div>

      <?php $i++ ?>
    <?php endforeach ?>

      </div>
</div>