function sortBy(n){
    var table, i, x, y, count = 0;

    table = document.getElementById("invTable");
    var switching = true;
    
    var direction = "ascending";
    
    while (switching) {
        switching = false;
        var rows = table.rows;
        
        for (i = 1; i < (rows.length - 1); i++) {
            var Switch = false;
            
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            
            // Check the direction of order 
            if (direction == "ascending") { 
 
                // Check if 2 rows need to be switched 
                if (x.innerHTML.toString() > y.innerHTML.toString()) 
                    { 
                        // If yes, mark Switch as needed and break loop 
                        Switch = true; 
                        break; 
                    } 
            } else if (direction == "descending") { 
  
                // Check direction 
                if (x.innerHTML.toString() < y.innerHTML.toSting()) 
                    { 
                        // If yes, mark Switch as needed and break loop 
                        Switch = true; 
                        break; 
                    } 
            }         
        }
        if(Switch) {
            rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
            switching = true;
            
            // Increase count for each switch 
            count++; 
        }else { 
             // Run while loop again for descending order 
                if (count == 0 && direction == "ascending") { 
                    direction = "descending"; 
                    switching = true; 
                } 
           } 
    }
}


