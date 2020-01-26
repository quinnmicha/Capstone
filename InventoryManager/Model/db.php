
        <?php
        
       $config = array(
            'DB_DNS' => 'mysql:host=ict.neit.edu;port=5500;dbname=se266_008005114',
            'DB_USER' => 'se266_008005114',
            'DB_PASSWORD' => '008005114'
        );
       
        $db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        
 
        ?>
