<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_name = 'payment-error-page';
    $page_title = "Payment Failed";
    // Include header
    require_once(LAYOUTS_PATH . "/header.php");
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");

    // Retrieve chosen path id
    $a_key      = strip_tags($_GET['pid']);
    $b_key      = stripslashes($a_key);
    $c_key      = htmlspecialchars($b_key, ENT_QUOTES);
    $p_hash_key = strip_tags($c_key);

    // Select random route
    $route_check = [ 'zLc9H5zH3BCVxalkfGnwcL4kPAax4mbSHycudUm', 'Qau7FkKRfDxQP5j8FLtdafYunUiLrFV8Cnm6Rb', 'G2uGfeydjtWGh3DCgPNap09gmfDg2XgKpQPd3EVr', 'HjkhVmBub7XH8yiRc957ny5F8tftr9jhcmprF586bKM', 'Cm4yS5WaflkjEAdpfhg8xSaAwRcneFngKQdzwLfZyzi', 'pb8ptwtWdZjjsalbmb2ZMP8D25AvmxtWecSVtH', 'giMBjVfZpeeQhvDxPuMjWvPCh6Tybw2yEPH82V', 'ZAQKWHppWgdnjnuC6Zhj8RuU8dF7zTnARpunmb9aVL', 'VFurJCbRj5ambKhkHR8cYKFdBGCzfTMqmbQTJniHPc', 'J9BhffhMfhdDVj3890387W33ZdVXP6jvteLcM4U', 'nBcEkYuWm6XyiKn84ZWQELJGdZ56547iNdyCgyL', 'GSyC458zw2kmUfSxFdd5NN3L575k8pV9PrfLU4dpBA', '8CRrgSuGzuaH2US33WkQvtBWMykhkjtxVkJHK6JnmD', '8h4hWgqagXpNu7E4uGKK5kSUeVfuhKjV8gZaUM', '66dZV3HeXup5464683MN8Q2f8pD4Ax558ZH', 'tPDRinu3vuNAQA9zbshkjg55VUTEgMRAJxwJqxu', 'ceC74BT2TGuV87sdM6KJ2JmT3TLyxMJAL8U23', 'GD8GBvMt6H3FfzeShn7GbGfm5edJfZXPP3v4M', '98Ue6465eQp4HgXJ9NA7zzjlsd8MpZPtFzxehU', 'UCNm9uEHWc6VypeKbqcSBQmrbQjFfkNeJpU', 'gKdSuB76ywyk2Tdsdd2p9Hd772CmmQTe7g', 'ChY3AcFZ8MAcWVkcfPjyZAYB6c6dfqaRahmWPf', 'bQJc8EPfGE4MqwLh587kdgxzY86fxqeTLxBEkC', 'Pe4D3BJK5Gxa6AwGmjslgdjlvRCbVZkiyc2', 'R3Lvy5mbbmZN3YbYH64kdskhdBAprd8czVLnV6', 'WYuS8rdmQPzSa464646cbvDiJ2NM', 'xbEPWx2kjkj8YbV3wJ54648eSfzej34gBZS2gCubM', 'jAFjvzya5hkQKSDahDaKqJZQUarT564Pc2zY3LWK', 'rhcf9xNFPSJPG7ZjGMBmvt2XQZyAUv4JzbHuZQ', 'D4yRxLMexivB5q8rQ5gY74KnaimqLiaCSjAaxQ', 'TN9JLrbKWWFsdk3543nxL3CEZytnUEeRxXeg', 'KdYPFdpEFZmcjpyMFepYu9kqDiMV7KFEjRRY89g4', 'YzV9vVhkhu49qRd38JEybt5q8L4KBBGPLTna67YKexM', '944zPSrjuLxu6CjX8bEzPnvFbwUTgggTVj3fPq3u', 'FfwtyEXYFNHctctSL37ub3Zh2m6V9YqdKnApbpvV', '4jjCxRkd5223cDGkpdtqbKD5tSWR57tRxf', 'u2RcHjAJhkhizfaiQVTGNnicB7mtFFdA3ACqi3Az', 'eibSd53WX4TgJzwYxSTc3buRZSMikkcc4MEh4xK6', 'MBP9mMbQtrryrajddf7VyuQ9nfVZZM8cJRxzPG', 'MJQcdsgssmHXjXfndQnKwvCMdZrFrdZhVVyQ', 'ECmSWCRikhkQj66D3Jg4NHSb2BEgaeYJytiDuD4y', '25qZQwhGVm5jhgjjgzQh6EpAPKBU76Mcecp', '4vFKHgBnSfjgjgjVQQyqkVKuVziAFx75A', 'zMAderUikxxcDyTACTYwu8KSVQSAxBvg9bkmYJFv', 'f645DWKthWcrNjJV73pPewQMRmv73AMHvdwEevKM', 'u2uyVkinnFWmrhjhjQp4BAeWDS5V6wgc5Gn2QNJ5', 'pAemPNwQaz3NYhBDr8HibpERD2WS5qen7Ah3CaUE', 'KwJWggLKNVDQrA2VEjG7hB49Jr27Xt6VSXXfp3YC', 'CJSAPfY4Y9CQhjdfdaRfWtMruaZZJrZCtYhGxEU', 'ZYjjfds545RQNthAjznwcCVY2dFjQ2BJ2fkjEELThq2eY' ];

    // Rerout if from wrong url path
    $re_route = BASE_PATH;
    if (!in_array($p_hash_key, $route_check)) {
        header("location:".$re_route);
        exit;
    }
?>
<style>
    <?php include("./ticket.css");  ?>
</style>

<!-- body -->
<div class="page_content">
   <div class="bg_light payment_success_box d-flex justify-content-center align-items-center">
        <div class="container-lg">
            <div class="row">
                <div class="col-lg-10 col-md-10 col-sm-12 offset-lg-1">
                    <div class="row" id="precessMsgContainer">
                        <div class="jumbotron clean_shadow mt-0 py-4 boder_all_dark py-5 noselect">
                            <h2 class="text-center payment_success_title">Payment Failed!</h2>
                            <h3 class="text-center pt-2" id="paySuccessMsg">Your payment was unsuccessful. We will refund your money incase you paid anything.</h3>
                            <div class="text-center py-2 payment_success_icon" id="paySuccessIcon"><i class="bi bi-x-circle text-danger"></i></div>
                            <center class="mb-2">
                                <a href="<?php echo SECTION_PATH.'tickets/ticket_checkout'; ?>" class="btn btn-lg btn-dark p-2">Back to cart</a>
                                <a href="<?php echo SECTION_PATH.'events/'; ?>" class="btn btn-lg btn-secondary p-2">Check out more events</a>
                            </center>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
   </div>         
</div>

<!-- footer -->
<?php 
require_once(LAYOUTS_PATH . "/footer.php"); 
?>
