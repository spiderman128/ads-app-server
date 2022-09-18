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

$pageTitle = 'Pay Bkash';

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$user = $_GET['user'];
	$sql = "UPDATE users SET pending = 0 WHERE mobile = $user;";
	$sql .= "UPDATE payments SET status = 'Paid' WHERE id = $id";
	
	if ($conn -> multi_query($sql) === TRUE) {
		//snack ("success", "Success");
		header('location: pay-bkash.php?success');
	}
	
}

$sql = "SELECT * FROM payments WHERE status='Pending' AND method = 'Bkash' ORDER BY id ASC";
$data = mysqli_query($conn, $sql);
$index = 1;

$sql2 = "SELECT
		( SELECT COUNT(1) FROM payments WHERE status = 'Pending' AND method = 'Bkash') AS payment_count,
		( SELECT SUM(amount) FROM payments WHERE status = 'Paid') AS paid_amount,
		( SELECT SUM(amount) FROM payments WHERE status = 'Pending') AS pending_amount
		FROM dual";
		
$result2 = $conn -> query($sql2);
$data2 = $result2 -> fetch_assoc();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Pay Bkash</title>
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
		<main>
		    <section class="bordedr fr-container fr-lg">
		        <div class="table-wrapper" style="overflow: auto">
			<table class="table table-divo">
				<thead><tr>
					<th scope="col"><i class="material-icons" style="vertical-align: -3px">insights</i> <?= $data2['payment_count'] ?? '0' ?></th>
					<th scope="col">Date</th>
					<th scope="col">User</th>
					<th scope="col">Payment Number</th>
					<th scope="col">Amount</th>
					<th scope="col">Method</th>
					<th scope="col">Action</th>
				</tr></thead>
				<tbody>
					<?php
					if (mysqli_num_rows($data) > 0) {
						while($row = mysqli_fetch_assoc($data)) {
							echo "<tr><td>{$index}</td><td>{$row['date']}</td><td class='text-muted'>{$row['mnumber']}</td><td class='select'>{$row['number']}</td><td>{$row['amount']}</td><td>{$row['method']}</td><td><a href='?id={$row['id']}&user={$row['mnumber']}' class='btn btn-success btn-block'><span class='material-icons'>check</span></a></td></tr>\n";
							$index++;
						}
					}
					?>
				</tbody>
			</table>
			</div>
			</section>
		</main>
		
		<a data-toggle="modal" data-target="#settingsModal" class="fab bg-primary material-icons col-white">settings</a>
		
        <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="settingsModal" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">
                    <span class="material-icons" style="vertical-align: -3px">settings</span>
                    Settings
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="inline">
                        <label class="switch mr-2">
                            <input type="checkbox" id="mode-toggler">
                            <span class="slider round"></span>
                            <p></p>
                        </label>
                        Compact Mode
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>
		
		<?php if (isset($_GET['success'])) : ?>
			<p class="snackbar success">Success</p>
		<?php endif ?>
		<?php include('footer.php') ?>
		
		
		
		<script>
		
		    function getCookie(cname) {
              var name = cname + "=";
              var decodedCookie = decodeURIComponent(document.cookie);
              var ca = decodedCookie.split(';');
              for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                  c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
                }
              }
              return '';
            }
            
            function enableCompact() {
                $('th:nth-child(1), tr td:nth-child(1)').hide();
                $('th:nth-child(2), tr td:nth-child(2)').hide();
                $('th:nth-child(3), tr td:nth-child(3)').hide();
            }
            
            function disableCompact() {
                $('th:nth-child(1), tr td:nth-child(1)').show();
                $('th:nth-child(2), tr td:nth-child(2)').show();
                $('th:nth-child(3), tr td:nth-child(3)').show();
            }
            
            function setMode() {
                let isCompactEnabled = getCookie('compact') == 'true';
                
                if(isCompactEnabled) {
                    $('#mode-toggler').prop('checked', true);
                    enableCompact();
                } else {
                    $('#mode-toggler').prop('checked', false);
                    disableCompact();
                }
            }
		    
		    $('#mode-toggler').change(function() {
                if(this.checked) {
                    document.cookie = "compact=true; expires=Thu, 18 Dec 2070 12:00:00 UTC";
                } else {
                    document.cookie = "compact=false; expires=Thu, 18 Dec 2070 12:00:00 UTC";
                }
                
                setMode();
            });
            
            setMode();
            
            
            $(document).on('click', '[data-id]', function(e) {
		        let elem = $(this);
		        let id = $(this).data('id');
		        let user = $(this).data('user');
		        elem.find(">:first-child").html('scatter_plot');
                $.post("pay-users.php",
                {
                    id: id,
                    user: user
                },
                function(data, status){
                    if(status == 'success') {
                        document.body.insertAdjacentHTML('beforeend', data);
                        elem.closest('tr').fadeOut("normal", function() {
                            $(this).remove();
                            $('#count').html($('#count').html() - 1);
                            $('tr td:first-child').each(function(i , el) {
                                $(this).html(i + 1);
                            })
                            if($('#count').html() == '0') {
                                makeFrContainerNoRecord();
                            }
                        });
                    }  else {
                        elem.find(">:first-child").removeClass('btn-success').addClass('btn-danger').html('check');
                    }
                });
            });
		    
		</script>
		
		
		
	</body>
</html>
	