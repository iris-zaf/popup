   <?php
    require_once __DIR__ . '/../config/config.php';
    require_once __DIR__ . '/../includes/functions.php';

    $page = $_GET['page'] ?? 'home';
    $settings = get_popup_settings($page);
    require_once __DIR__ . '/../views/popup-view.php';
    echo "" . $_SERVER['DOCUMENT_ROOT'] . "/views/popup-view.php";
    ?>
   <!--  FOR production -->
   <script src="/assets/js/frontend-scripts.js"></script>
   <!-- FOR localhost
   <script>
       const settings = <?= json_encode(get_popup_settings($page)) ?>;
   </script>
   <script src="<?= PLUGIN_ASSETS ?>js/frontend-scripts.js"></script>-->
   </body>

   </html>