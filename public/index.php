<?php
  require_once '../app/bootstrap.php';
  require_once '../app/Controllers/TeamController.php';
  $teams = App\Controllers\TeamController::fetchAll();
  
?>
<html>
  <head>
    <title>NBA 2k19</title>
  </head>
  <body>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Code</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($teams as $team): ?>
            <tr>
              <td><?= $team->code; ?></td>
              <td><?= $team->name; ?></td>
              <td>
                <button>show</button>
                <button>delete</button>
              </td>
            </tr>"
          <?php endforeach; ?>
      </tbody>
    </table>
  </body>
</html>