isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.MainMenu = isc.myMenu.create({
			title: "...",
			showShadow: true,
			items: [
				// {title: "Books", submenu: this.BookMenu},
				// {isSeparator: true},
				{title: "Items", click: "isc.Items.create()"},
				{title: "Lookups", click: "isc.Lookups.create()"}
				// {title: "Show Log", click: "isc.ShowLog.create({width: 1200, height: \"95%\"})"}
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 20,
			width: 20,
			menus: [this.MainMenu]
		});
	}
});
