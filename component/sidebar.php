<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="active">
<a href="<?= $base_url ?>dashboard.php"><img src="<?= $base_url ?>assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
</li>
<li class="submenu">
    
<a href="<?= $base_url ?>product/list.php"><img src="<?= $base_url ?>assets/img/icons/product.svg" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>product/list.php">Product List</a></li>

<li><a href="<?= $base_url ?>categories/list.php">Category</a></li>

</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>sales/list.php"><img src="<?= $base_url ?>assets/img/icons/sales1.svg" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>sales/list.php">Sales List</a></li>
<li><a href="<?= $base_url ?>sales/create.php">Add Sale</a></li>
<li><a href="<?= $base_url ?>sales_return/list.php">Sales Return List</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>purchase/list.php"><img src="<?= $base_url ?>assets/img/icons/purchase1.svg" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>purchase/list.php">Purchase List</a></li>
<li><a href="<?= $base_url ?>purchase/create.php">Add Purchase</a></li>
<li><a href="<?= $base_url ?>supplier/list.php">Supplier</a></li>


</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>stock/list.php"><i data-feather="box"></i> <span>Stocks</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>stock/list.php">Stock list</a></li>
<li><a href="<?= $base_url ?>stock_transfer/list.php">Stock Transfer</a></li>

</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>expense/list.php"><img src="<?= $base_url ?>assets/img/icons/expense1.svg" alt="img"><span> Expense</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>expense/list.php">Expense List</a></li>
<li><a href="<?= $base_url ?>expense/create.php">Add Expense</a></li>
<li><a href="<?= $base_url ?>expense_categories/list.php">Expense Category</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>customer/list.php"><img src="<?= $base_url ?>assets/img/icons/quotation1.svg" alt="img"><span> Customer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>customer/list.php">Customer List</a></li>
 
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>transfer/list.php"><img src="<?= $base_url ?>assets/img/icons/transfer1.svg" alt="img"><span> Transfer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>transferlist.php">Transfer List</a></li>
<li><a href="<?= $base_url ?>addtransfer.php">Add Transfer </a></li>
<li><a href="<?= $base_url ?>importtransfer.php">Import Transfer </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>sales_return/list.php"><img src="<?= $base_url ?>assets/img/icons/return1.svg" alt="img"><span> Return</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>sales_return/list.php">Sales Return List</a></li>
<li><a href="<?= $base_url ?>sales_return/create.php">Add Sales Return </a></li>
<li><a href="<?= $base_url ?>purchase_return/list.php">Purchase Return List</a></li>
<li><a href="<?= $base_url ?>purchase_return/create.php">Add Purchase Return </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>accounts/list.php"><i data-feather="book"></i><span> Account Heads</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>accounts/list.php">Accounts List</a></li>
<li><a href="<?= $base_url ?>accounts/create.php">Add Accounts </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>customerlist.php">Customer List</a></li>
<li><a href="<?= $base_url ?>addcustomer.php">Add Customer </a></li>
<li><a href="<?= $base_url ?>supplierlist.php">Supplier List</a></li>
<li><a href="<?= $base_url ?>addsupplier.php">Add Supplier </a></li>
<li><a href="<?= $base_url ?>users/list.php">User List</a></li>
<li><a href="<?= $base_url ?>users/add.php">Add User</a></li>
<li><a href="<?= $base_url ?>storelist.php">Store List</a></li>
<li><a href="<?= $base_url ?>addstore.php">Add Store</a></li>
</ul>
</li>
<li>
<a href="<?= $base_url ?>warehouse/list.php"><i data-feather="layers"></i><span> warehouse</span> </a>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>tables-basic.php">Basic Tables </a></li>
<li><a href="<?= $base_url ?>data-tables.php">Data Table </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/time.svg" alt="img"><span> Report</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>purchaseorderreport.php">Purchase order report</a></li>
<li><a href="<?= $base_url ?>inventoryreport.php">Inventory Report</a></li>
<li><a href="<?= $base_url ?>salesreport.php">Sales Report</a></li>
<li><a href="<?= $base_url ?>invoicereport.php">Invoice Report</a></li>
<li><a href="<?= $base_url ?>purchasereport.php">Purchase Report</a></li>
<li><a href="<?= $base_url ?>supplierreport.php">Supplier Report</a></li>
<li><a href="<?= $base_url ?>customerreport.php">Customer Report</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/users1.svg" alt="img"><span> Users</span> <span class="menu-arrow"></span></a>
<ul>

<li><a href="<?= $base_url ?>users/list.php">Users List</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/settings.svg" alt="img"><span> Settings</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>generalsettings.php">General Settings</a></li>
<li><a href="<?= $base_url ?>emailsettings.php">Email Settings</a></li>
 <li><a href="<?= $base_url ?>paymentsettings.php">Payment Settings</a></li>
<li><a href="<?= $base_url ?>currencysettings.php">Currency Settings</a></li>
<li><a href="<?= $base_url ?>grouppermissions.php">Group Permissions</a></li>
<li><a href="<?= $base_url ?>taxrates.php">Tax Rates</a></li>
</ul>
</li>
</ul>
</div>
</div>
</div>
