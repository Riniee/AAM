<?php
$lock = CardManager::checkLocked($_GET['cardId']);
$lockurl = '';
$unlockurl = '';
if ($access) { 
	if ($card['ASIGNEE'] == 'Reviewer') { ?>
    <li class="pull-right" style="display:none;" id="ready_for_proofreading">
        <div class="button-wrapper" onclick="sendToPR('fwd_to_proofreader.php', <?php echo $card['ID'] ?>);"><span>Ready for Proofreading</span></div>
    </li>
    <?php
	}

	if ($card['ASIGNEE'] == 'Proof Reader') { ?>
        <li class="pull-right" style="display:none;" id="send_to_proof_admin">
            <div class="button-wrapper" onclick="sendToPA('fwd_to_proofadmin.php', <?php echo $card['ID'] ?>);"><span>Send to Proof Admin</span></div>
        </li>
        <?php } 
			  
	if ($card['ASIGNEE'] == 'Proof Admin') { ?>
        <li class="pull-right" style="display:none;" id="finish_approve">
            <div class="button-wrapper" onclick="generatePDF(<?php echo $card['ID'] ?>);"><span>Finish and Approve</span></div>
        </li>
        <li class="pull-right" style="display:none;" id="send_proof_to_Member">
            <div class="button-wrapper" onclick="sendToPR('fwd_to_proofreader.php', <?php echo $card['ID'] ?>);"><span>Send proof to Member</span></div>
        </li>
        <li class="pull-right" style="display:none;" id="send_back_to_review">
            <div class="button-wrapper" onclick="sendToReviewer('fwd_to_reviewer.php', <?php echo $card['ID'] ?>);"><span>Send back for Review</span>
            </div>
        </li>
        <?php } ?>
        <?php  
        $lockurl = 'lock_card.php?card_id=' . $card['ID'];
        $unlockurl = 'unlock_card.php?card_id=' . $card['ID'];
        if($lock) {
            ?>
        <li id="unlock-btn">
            <div class="button-wrapper" onclick="unlockCard(this);"><i class="fa fa-lock" style="color:#b67815;"></i><span>Unlock</span></div>
        </li>
        <?php } else{ ?>
        <li id="lock-btn">
            <div class="button-wrapper" onclick="lockCard(this)"><i class="fa fa-lock" style="color:#b67815;"></i><span>lock</span></div>
        </li>
        <?php } ?>
        <li id="forward-btn">
            <div class="button-wrapper" onclick="showForwardTab();"><i class="fa fa-share" style="color:#f3b701;"></i><span>forward</span></div>
        </li>
        <li id="return-btn">
            <div class="button-wrapper" onclick="returnBack(<?php echo $card['ID'] ?>)"><i class="fa fa-reply" style="color:#f3b701;"></i><span>return</span></div>
        </li>
        <li id="share-btn">
            <div class="button-wrapper"><i class="fa fa-share-alt" style="color:#004592;"></i><span>share</span></div>
        </li>

        <?php	
	} else {
	if (isset($_GET['otherUserId'])) {
		$url .= '&otherUserId=' . $_GET['otherUserId'];
	}
?>

            <li id="claim-btn">
                <div class="button-wrapper" onclick="claimCard(this);"><i class="fa fa-lock" style="color:#b67815;"></i><span>Claim</span></div>
            </li>
            <li id="claim-open-btn">
                <div class="button-wrapper" onclick="claimOpenCard(this);"><i class="fa fa-share" style="color:#f3b701;"></i><span>Claim & Open</span></div>
            </li>
            <script>
                $('#form-tab').hide();
                $('#history-tab').hide();
                $('#attachments-tab').hide();
                $('#unlock-btn').hide();

            </script>
            
            <?php } ?>

            <script>
                function lockCard(btn) {
                    var url ='<?php echo $lockurl ?>';
                    $.ajax({
                            url: url,
                            type: "GET"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            $('#lock-btn').hide();
                            $('#unlock-btn').show();
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function unlockCard(btn) {
                    var url ='<?php echo $unlockurl ?>';
                    $.ajax({
                            url: url,
                            type: "GET"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            $('#unlock-btn').hide();
                            $('#lock-btn').show();
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function claimCard(btn) {
                    //btn.disabled = true;
                    $(btn).prop('disabled', true);
                    var url = '<?php echo $url ?>';
                    $.ajax({
                            url: url,
                            type: "GET"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            $('#claim-btn').hide();
                            //Modal.show('Claim Card', json.success, '');
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function claimOpenCard(btn) {
                    btn.disabled = true;
                    var url = '<?php echo $url ?>';
                    $.ajax({
                            url: url,
                            type: "GET"
                        })
                        .done(function(json) {
                            console.log(json);
                            $('#claim-open-btn').hide();
                            window.location.reload();
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function showFormTab() {
                    manageButtons();
                    $('#save_to_user_worklist').show();
                    $('#save_to_reviewer_worklist').show();
                    $('#ready_for_proofreading').show();
                    $('#save_to_proofreader_worklist').show();
                    $('#send_back_to_review').show();
                    $('#send_proof_to_Member').show();
                    $('#send_to_proof_admin').show();
                    $('#save_to_proofreader_worklist').show();
                    $('#send_back_to_proofreading').show();
                    $('#finish_approve').show();
                }

                function manageButtons() {
                    $('#lock-btn').hide();
                    $('#forward-btn').hide();
                    $('#return-btn').hide();
                    $('#share-btn').hide();
                    hideButtons();
                }

                function showTaskDetailsButton() {
                    $('#lock-btn').show();
                    $('#forward-btn').show();
                    $('#return-btn').show();
                    $('#share-btn').show();
                    hideButtons();
                }

                function hideButtons() {
                    $('#save_to_user_worklist').hide();
                    $('#save_to_reviewer_worklist').hide();
                    $('#ready_for_proofreading').hide();
                    $('#save_to_proofreader_worklist').hide();
                    $('#send_back_to_review').hide();
                    $('#send_proof_to_Member').hide();
                    $('#send_to_proof_admin').hide();
                    $('#save_to_proofreader_worklist').hide();
                    $('#send_back_to_proofreading').hide();
                    $('#finish_approve').hide();
                }

                function sendToReviewer(url, cardId) {
                    $.ajax({
                            url: url,
                            data: {
                                card_id: cardId
                            },
                            type: "POST"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            //Modal.show('Card send back to Reviewer', json.success, '');
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function sendToPA(url, cardId) {
                    $.ajax({
                            url: url,
                            data: {
                                card_id: cardId
                            },
                            type: "POST"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            //Modal.show('Card send back to Proof Admin', json.success, '');
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function sendToPR(url, cardId) {
                    $.ajax({
                            url: url,
                            data: {
                                card_id: cardId
                            },
                            type: "POST"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            //Modal.show('Card send back to Proof Admin', json.success, '');
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function generatePDF(cardId) {
                    var newWindow = window.open("", "_blank");
                    $.ajax({
                            url: 'finish_card.php',
                            data: {
                                card_id: cardId
                            },
                            type: "POST"
                        })
                        .done(function(json) {
                            console.log(json);
                            
                            newWindow.location.href = '<?php echo $pdfUrl; ?>';
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }

                function showForwardTab() {
                    manageButtons();
                    $('#user-selection-tab').show();
                    $('#myTabs a[href="#forward"]').tab('show');
                }

                function sendToOtherUser(cardId) {
                    $('#forward-user-btn').prop('disabled', true);
                    $('#forward-cancel-btn').prop('disabled', true);
                    var userId = $('#forward-user').val();
                    $.ajax({
                            url: 'fwd_to_otheruser.php',
                            data: {
                                card_id: cardId,
                                user_id: userId
                            },
                            type: "POST"
                        })
                        .done(function(json) {
                            json = JSON.parse(json);
                            //Modal.show('Card send back to Reviewer', json.success, '');
                            window.location = 'dashboard.php';
                        })
                        .fail(function(xhr, status, errorThrown) {
                            console.log(xhr);
                        });
                }
                
                function returnBack(cardId) {                    
                    var url = 'returnPrevious.php';                    
                    $.ajax({
                        url: url,
                        data : {
                            card_id:cardId,                            
                        },
                        type: "POST"
                    })
                      .done(function( json ) {
                          json = JSON.parse(json);
                          //Modal.show('Card send back to Reviewer', json.success, '');
                          window.location = 'dashboard.php';
                      })
                      .fail(function( xhr, status, errorThrown ) {
                          console.log(xhr);
                      });
                }       
                
                function enable_fwd_btn() {
                    $('#forward-user-btn').prop('disabled', false);
                    $('#forward-cancel-btn').prop('disabled', false);
                }

                function clearData() {
                    $('#forward-user-btn').prop('disabled', true);
                    $('#forward-cancel-btn').prop('disabled', true);
                    $('#forward-user').val('');
                }

            </script>
