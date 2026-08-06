<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="active">
<a href="<?= $base_url ?>dashboard.php"><img src="<?= $base_url ?>assets/img/icons/dashboard.svg" alt="img"><span> Dashboard</span> </a>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/product.svg" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>productlist.php">Product List</a></li>
<li><a href="<?= $base_url ?>addproduct.php">Add Product</a></li>
<li><a href="<?= $base_url ?>categories/list.php">Category</a></li>

</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/sales1.svg" alt="img"><span> Sales</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>saleslist.php">Sales List</a></li>
<li><a href="<?= $base_url ?>pos.php">POS</a></li>
<li><a href="<?= $base_url ?>pos.php">New Sales</a></li>
<li><a href="<?= $base_url ?>salesreturnlists.php">Sales Return List</a></li>
<li><a href="<?= $base_url ?>createsalesreturns.php">New Sales Return</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/purchase1.svg" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>purchaselist.php">Purchase List</a></li>
<li><a href="<?= $base_url ?>addpurchase.php">Add Purchase</a></li>
<li><a href="<?= $base_url ?>importpurchase.php">Import Purchase</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/expense1.svg" alt="img"><span> Expense</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>expenselist.php">Expense List</a></li>
<li><a href="<?= $base_url ?>createexpense.php">Add Expense</a></li>
<li><a href="<?= $base_url ?>expensecategory.php">Expense Category</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/quotation1.svg" alt="img"><span> Customer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>customer/list.php">Customer List</a></li>
 <li><a href="<?= $base_url ?>addquotation.php">Add Quotation</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/transfer1.svg" alt="img"><span> Transfer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>transferlist.php">Transfer List</a></li>
<li><a href="<?= $base_url ?>addtransfer.php">Add Transfer </a></li>
<li><a href="<?= $base_url ?>importtransfer.php">Import Transfer </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/return1.svg" alt="img"><span> Return</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>salesreturnlist.php">Sales Return List</a></li>
<li><a href="<?= $base_url ?>createsalesreturn.php">Add Sales Return </a></li>
<li><a href="<?= $base_url ?>purchasereturnlist.php">Purchase Return List</a></li>
<li><a href="<?= $base_url ?>createpurchasereturn.php">Add Purchase Return </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/users1.svg" alt="img"><span> People</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>customerlist.php">Customer List</a></li>
<li><a href="<?= $base_url ?>addcustomer.php">Add Customer </a></li>
<li><a href="<?= $base_url ?>supplierlist.php">Supplier List</a></li>
<li><a href="<?= $base_url ?>addsupplier.php">Add Supplier </a></li>
<li><a href="<?= $base_url ?>userlist.php">User List</a></li>
<li><a href="<?= $base_url ?>adduser.php">Add User</a></li>
<li><a href="<?= $base_url ?>storelist.php">Store List</a></li>
<li><a href="<?= $base_url ?>addstore.php">Add Store</a></li>
</ul>
</li> <li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/places.svg" alt="img"><span> Places</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>newcountry.php">New Country</a></li>
<li><a href="<?= $base_url ?>countrieslist.php">Countries list</a></li>
<li><a href="<?= $base_url ?>newstate.php">New State </a></li>
<li><a href="<?= $base_url ?>statelist.php">State list</a></li>
</ul>
</li>
<li>
<a href="<?= $base_url ?>components.php"><i data-feather="layers"></i><span> Components</span> </a>
</li>
<li>
<a href="<?= $base_url ?>blankpage.php"><i data-feather="file"></i><span> Blank Page</span> </a>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="alert-octagon"></i> <span> Error Pages </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>error-404.php">404 Error </a></li>
<li><a href="<?= $base_url ?>error-500.php">500 Error </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="box"></i> <span>Elements </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>sweetalerts.php">Sweet Alerts</a></li>
<li><a href="<?= $base_url ?>tooltip.php">Tooltip</a></li>
<li><a href="<?= $base_url ?>popover.php">Popover</a></li>
<li><a href="<?= $base_url ?>ribbon.php">Ribbon</a></li>
<li><a href="<?= $base_url ?>clipboard.php">Clipboard</a></li>
<li><a href="<?= $base_url ?>drag-drop.php">Drag & Drop</a></li>
<li><a href="<?= $base_url ?>rangeslider.php">Range Slider</a></li>
<li><a href="<?= $base_url ?>rating.php">Rating</a></li>
<li><a href="<?= $base_url ?>toastr.php">Toastr</a></li>
<li><a href="<?= $base_url ?>text-editor.php">Text Editor</a></li>
<li><a href="<?= $base_url ?>counter.php">Counter</a></li>
<li><a href="<?= $base_url ?>scrollbar.php">Scrollbar</a></li>
<li><a href="<?= $base_url ?>spinner.php">Spinner</a></li>
<li><a href="<?= $base_url ?>notification.php">Notification</a></li>
<li><a href="<?= $base_url ?>lightbox.php">Lightbox</a></li>
<li><a href="<?= $base_url ?>stickynote.php">Sticky Note</a></li>
<li><a href="<?= $base_url ?>timeline.php">Timeline</a></li>
<li><a href="<?= $base_url ?>form-wizard.php">Form Wizard</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="bar-chart-2"></i> <span> Charts </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>chart-apex.php">Apex Charts</a></li>
<li><a href="<?= $base_url ?>chart-js.php">Chart Js</a></li>
<li><a href="<?= $base_url ?>chart-morris.php">Morris Charts</a></li>
<li><a href="<?= $base_url ?>chart-flot.php">Flot Charts</a></li>
<li><a href="<?= $base_url ?>chart-peity.php">Peity Charts</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="award"></i><span> Icons </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>icon-fontawesome.php">Fontawesome Icons</a></li>
<li><a href="<?= $base_url ?>icon-feather.php">Feather Icons</a></li>
<li><a href="<?= $base_url ?>icon-ionic.php">Ionic Icons</a></li>
<li><a href="<?= $base_url ?>icon-material.php">Material Icons</a></li>
<li><a href="<?= $base_url ?>icon-pe7.php">Pe7 Icons</a></li>
<li><a href="<?= $base_url ?>icon-simpleline.php">Simpleline Icons</a></li>
<li><a href="<?= $base_url ?>icon-themify.php">Themify Icons</a></li>
<li><a href="<?= $base_url ?>icon-weather.php">Weather Icons</a></li>
<li><a href="<?= $base_url ?>icon-typicon.php">Typicon Icons</a></li>
<li><a href="<?= $base_url ?>icon-flag.php">Flag Icons</a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="columns"></i> <span> Forms </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>form-basic-inputs.php">Basic Inputs </a></li>
<li><a href="<?= $base_url ?>form-input-groups.php">Input Groups </a></li>
<li><a href="<?= $base_url ?>form-horizontal.php">Horizontal Form </a></li>
<li><a href="<?= $base_url ?>form-vertical.php"> Vertical Form </a></li>
<li><a href="<?= $base_url ?>form-mask.php">Form Mask </a></li>
<li><a href="<?= $base_url ?>form-validation.php">Form Validation </a></li>
<li><a href="<?= $base_url ?>form-select2.php">Form Select2 </a></li>
<li><a href="<?= $base_url ?>form-fileupload.php">File Upload </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><i data-feather="layout"></i> <span> Table </span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>tables-basic.php">Basic Tables </a></li>
<li><a href="<?= $base_url ?>data-tables.php">Data Table </a></li>
</ul>
</li>
<li class="submenu">
<a href="<?= $base_url ?>javascript:void(0);"><img src="<?= $base_url ?>assets/img/icons/product.svg" alt="img"><span> Application</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?= $base_url ?>chat.php">Chat</a></li>
<li><a href="<?= $base_url ?>calendar.php">Calendar</a></li>
<li><a href="<?= $base_url ?>email.php">Email</a></li>
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
<li><a href="<?= $base_url ?>newuser.php">New User </a></li>
<li><a href="<?= $base_url ?>userlists.php">Users List</a></li>
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