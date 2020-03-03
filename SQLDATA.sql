SELECT inventory.`name`, bought, sold
FROM (SELECT idItem, Sum(amount) as bought, (SELECT Sum(sales.amount) as sold FROM sales WHERE week = 27 Group By sales.idItem ) AS sold FROM purchases WHERE week = 27 GROUP BY idItem ) AS purchaseTable 
LEFT Join inventory ON purchaseTable.idItem = inventory.idItem 
UNION ALL SELECT name, (SELECT Sum(purchases.amount) FROM purchases WHERE week =27 GROUP BY purchases.idItem) AS bought, Sum(sales.amount) as sold FROM sales JOIN inventory ON sales.idItem = inventory.idItem WHERE week = 27 Group By sales.idItem 