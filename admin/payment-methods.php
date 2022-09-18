<?php
session_start();

require_once('functions.php');
require_once('dbconnection.php');
require_once('includes/init.php');

$password = $_SESSION['password'];
$admin_data = get_admin($conn, $password);
if ($password != $admin_data['password']) {
	header('location: login.php');
}
if ( !isset($_SESSION['password']) ) {
	header('location: login.php');
}
if ( empty( $admin_data ) ) header('location: login.php');

$pageTitle = 'Payment Methods';

if (isset($_POST['add'])) {
if (isset($_POST['id'])){
$id = compactify($conn, $_POST['id']);
}
$name = compactify($conn, $_POST['name']);
$amount = compactify($conn, $_POST['amount']);
$type = compactify($conn, $_POST['type']);
$hint = compactify($conn, $_POST['hint']);
$sql = "INSERT INTO methods (name, amount, type, hint) VALUES ('$name', '$amount', '$type', '$hint')";
  
	  if ($conn->multi_query($sql) === TRUE) {
		snack ("success", "Success");
	  } else {
		snack ("error", "Failed");
	  }
}
if (isset($_GET['delete'])) {
  $id = $_GET['id'];
    $sql = "DELETE FROM methods WHERE id = $id";
	$result = $conn -> query($sql);
    if ($result === TRUE) {
		snack ("success", "Success");
    } else {
    	snack ("error", "Failed");
    	echo $conn->error;
    }
}    
if (isset($_POST['edit'])) {
    $id = compactify($conn, $_POST['id']);
$name = compactify($conn, $_POST['name']);
$amount = compactify($conn, $_POST['amount']);
$type = compactify($conn, $_POST['type']);
$hint = compactify($conn, $_POST['hint']);
	$sql1 = "UPDATE methods SET name = '$name', amount = '$amount', type = '$type', hint = '$hint' WHERE id = $id";
	$result1 = $conn -> query($sql1);
	if ($result1 === TRUE) {
		header('location: payment-methods.php?success');
	}
	else {
	    snack ("error", "Failed");
	}
}

if (isset($_GET['edt'])){
    $id =  $_GET['id'];
$sql3 = "SELECT * FROM methods WHERE id = $id";
$res3 = $conn->query($sql3);
$user = mysqli_fetch_assoc($res3);
}


$sql = "SELECT * FROM methods ORDER BY id ASC";
$data = mysqli_query($conn, $sql);
$index = 1;

$sql2 = "SELECT
		( SELECT COUNT(1) FROM methods) AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pay Users</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=false, shrink-to-fit=no">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<style>
			.select {
				user-select: all;
			}
			tbody > tr:nth-child(even) {
				background: #F8F8F8;
			}
		</style>
	</head>
	<body>
		<?php include("header.php") ?>
		
		<?php if (!isset($_GET['edt'])) : ?> 
		<main>
		    <section class="bordedr fr-container fr-lg">
		        <div class="table-wrapper" style="overflow: auto">
			<table class="table table-divo">
				<thead><tr>
					<th scope="col"><i class="material-icons" style="vertical-align: -3px">insights</i> <?= $data2['payment_count'] ?? '0' ?></th>
					<th scope="col">Name</th>
					<th scope="col">Amount</th>
					<th scope="col">Account Type</th>
					<th scope="col">Hint</th>
					<th scope="col">Action</th>
				</tr></thead>
				<tbody>
					<?php
					if (mysqli_num_rows($data) > 0) {
						while($row = mysqli_fetch_assoc($data)) {
							echo "<tr><td>{$index}</td><td>{$row['name']}</td><td class='text-muted'>{$row['amount']}</td><td class='select'>{$row['type']}</td><td>{$row['hint']}</td><td><a class='btn btn-primary' href='?edt&id={$row['id']}'>
                               <span class='material-icons'>edit</span></button> <a href='?delete&id={$row['id']}' style='margin-left: 3px' class='btn btn-danger'> 
                                                <span class='material-icons'>delete</span>
                                            </a></td></tr>\n";
							$index++;
						}
					}
					?>
				</tbody>
			</table>
			</div>
			</section>
		</main>
		<!-- Add Method Form Modal -->

        <div class="modal fade" id="add-method-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Payment Method</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" class="mb-0">
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" spellcheck="false" required>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input name="amount" type="number" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Hint</label>
                                <input name="hint" type="text" class="form-control" spellcheck="false" required>
                            </div>
                            <div class="form-group">
							    <label>Account Type</label>
							    <select name="type" class="form-control">
								    <option value="number">Number</option>
								    <option value="email">Email</option>
								    <option value="text">Text</option>
							    </select>
						    </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i>close</i>Cancel</button>
                                <button name="add" value="true" type="submit" class="btn btn-success">
                                    <i>add</i>Add Method
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
         <?php else : ?>
        <!-- Edit Method Form Modal -->

    
                <main>
			<section class="fr-container fr-sm pb-0">
				<div class="mb-1">
                        <h5 class="modal-title">Edit  Method - <?= $user['name'] ?> </h5>
                        <br>
                        <form action="" method="POST" class="mb-0">
                            <input name="id" type="text" value="<?= $user['id'] ?>" hidden>
                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="name form-control" spellcheck="false" value="<?= $user['name'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Amount</label>
                                <input name="amount" type="number" class="amount form-control" value="<?= $user['amount'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Hint</label>
                                <input name="hint" type="text" class="hint form-control" value="<?= $user['hint'] ?>" spellcheck="false" required>
                            </div>
                            <div class="form-group">
							    <label>Account Type</label>
							    <select name="type" class="form-control type">
								    <option value="number">Number</option>
								    <option value="email">Email</option>
								    <option value="text">Text</option>
							    </select>
						    </div>
                            <div class="text-right">
                                <button name="edit" type="submit" class="btn btn-success">
                                    <i>check</i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </section>
            </main> 
        <?php endif ?>
<?php if (!isset($_GET['edt'])) : ?>
        <a href="#" data-toggle="modal" data-target="#add-method-form" class="fab bg-primary material-icons">add</a>
		<?php endif ?>
		<script>
		    
		    // Edit method modal

            $('#edit-method-form').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var modal = $(this)
                modal.find('.modal-title').text('Edit Method - ' + button.data('name'))
                modal.find('.id').val(button.data('id'))
                modal.find('.name').val(button.data('name'))
                modal.find('.amount').val(button.data('amount'))
                modal.find('.hint').val(button.data('hint'))
                modal.find('.type').val(button.data('type'))
              })
		    
		</script>
		
		<?php if (isset($_GET['success'])) : ?>
			<p class="snackbar success">Success</p>
		<?php endif ?>
		<?php include('footer.php') ?>
		

		
	</body>
</html>		