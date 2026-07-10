<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>трекер шекелей</title>
  <style>
    :root {
      --font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    table{
      border: 2px solid darkviolet;
      border-radius: 10px;
      box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    /* стащил с интернета*/
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(45deg, #5345BA, #0E0548);
      backdrop-filter: saturate(50%);
      color: #e0e0e0;
      font-family: var(--font-family);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      line-height: 1.6;
    }

  
    .container {
      font-size: 15px;
      max-width: 450px;
      width: 90%;
      padding: 40px;

    }

    h1 {
      margin-top: 0;
      font-size: 28px;
      font-weight: 700;
      background: linear-gradient(45deg, #FFE53B, #FF2525);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

</style>
</head>
<body>
  <container>
    <h1> Budget tracker </h1> 
  <table>
  <tr>
    <td> Date </td>
    <td> Check </td>
    <td>Description </td>
    <td> Amount </td>
  </tr>

  <?php if (! empty($transactions)) ?>
    <?php foreach ($transactions as  $transaction): ?>
      <tr>
        <td> <?= ($transaction['date']) ?></td>
        <td> <?= $transaction['checknumber'] ?></td>
        <td> <?= $transaction['description'] ?></td>
        <td> 
          <?php if ($transaction['amount'] < 0): ?>
            <span style="color: orangered;">
              <?= $transaction['amount'] ?></td>
            </span>
          <?php elseif ($transaction['amount'] > 0): ?>
            <span style="color: limegreen;">
              <?= $transaction['amount'] ?></td>
            </span>
          <?php else: ?>
            <?= $transaction['amount'] ?></td>
          <php endif ?>
      </tr>
    <?php endif ?>
    <?php endforeach ?>
  
  <tr>
    <td> total: </td>
    <td> <?= $totals['netTotal'] ?> $ </td>
  </tr>

  <tr>
    <td> expense: </td>
    <td> <?= $totals['totalExpense'] ?> $ </td>
  </tr>

  <tr>
    <td> income: </td>
    <td> <?= $totals['totalIncome'] ?> $ </td>
  </tr>

</table>
	


	</container>
</body>
</html>
