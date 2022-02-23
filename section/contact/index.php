<?php
    // Require config file
    require_once('../../backend/core/Config.php');
    // Require authorization file
    require_once (CORE_PATH . '/Auth.php' );

    $page_title = 'Contact Us: Get In Touch With Our Team';
    $contact_active = 'active';

    // Include header
    require_once(LAYOUTS_PATH . "/header.php"); 
    // Include nav bar
    require_once(LAYOUTS_PATH . "/main_navbar.php");
?>

<style>
    .main_container {
        position: relative;
        width: 100%;
        margin: 0 auto;
        padding-left: 0;
        padding-right: 0;
        z-index: 3;
        max-width: 1400px;
    }

    .main_contact_body_content_full {
        padding-right: 0;
    }

    .main_contact_body_content {
        position: relative;
        box-sizing: border-box;
        background: #fff;
    }

    .contact_static_page.contact_page_content {
        padding: 3rem 1rem 10rem;
    }

    .contact_page_content h1:first-child, h1:first-child {
        margin-top: 0;
    }

    .contact_static_page h1 {
        border-bottom: 1px solid #f3f3f3;
        padding-bottom: 1.8rem;
    }

    .contact_page_content p{
        margin-bottom: 2rem;
    }

    .contact_static_page .map_embed_wrapper {
        position: relative;
        padding-bottom: 5rem;
        padding-top: 2rem;
        height: auto;
    }
    .contact_static_page .map_embed_wrapper iframe{
        width: 100%;
        height: 45rem;
    }

    .contact_page_heading {
        font-size: 2.88rem;
        font-weight: 900;
    }

    /* Media query for mobiles */
    @media screen and (max-width: 786px){
        .contact_static_page .map_embed_wrapper iframe{
            width: 100%;
            height: 30rem;
        }
    }
</style>

<div class="page_content">

    <section class="bg_white">
        <div class="main_container">
          <div class="main_contact_body_content main_contact_body_content_full">
            <div class="contact_page_content contact_static_page">
              <div id="contact_page">
                <h1 class="contact_page_heading">Contact Us</h1>

                <p class="noselect">
                    <br>
                    <span>Do you have a question, a worry, a suggestion, or a piece of news you'd like to share with 3Music?&nbsp;</span><strong><a class="text-danger" target="_blank" href="mailto:shout@3music.tv">Send us a message.</a></strong><span>&nbsp;</span><br>
                    <br>
                    <span>If you are a photographer, model, or stylist who has been unexpectedly contacted by 3Music, please &nbsp;</span><a class="text-danger" target="_blank" href="mailto:shout@3music.tv"><strong>contact us</strong></a><span>&nbsp; or phone the number below to verify the hiring individual's or company's credentials.&nbsp;</span><br>&nbsp;
                </p>

                <div class="map_embed_wrapper noselect">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15882.873907074621!2d-0.2174034!3d5.6085343!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf913398bdb0a7db9!2s3Music%20HQ!5e0!3m2!1sen!2sgh!4v1630025692472!5m2!1sen!2sgh" width="600" height="450" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" style="border:0;" allowfullscreen=""></iframe>
                </div>

                <p>
                    <strong>Mailing address:</strong><br>
                    <span>No 12 Afunya Street</span><br>
                    <span>GPS: GA-092-5841</span><br>
                    <span>Abelenpke, Accra</span>
                </p>

                <p><span>Phone: (+233) 0302791949</span><br>
                  <span>Info Email:&nbsp;</span><a style="color: rgb(68, 68, 68); font-size: 0.89rem; font-style: normal; font-variant: normal;" href="mailto:shout@3music.tv">shout@3music.tv</a><br>
                  <span>Submit Content:&nbsp;</span><a style="color: rgb(68, 68, 68); font-size: 0.89rem; font-style: normal; font-variant: normal;" href="mailto:submit@3music.tv">submit@3music.tv</a>
                </p>
              </div>
            </div>
          </div>
        </div>
    </section>
  
</div>


<?php require_once(LAYOUTS_PATH . "/footer.php"); ?>