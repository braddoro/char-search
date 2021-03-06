isc.defineClass("Navigation", "Menu").addProperties({
	initWidget: function(initData){
		this.MainMenu = isc.myMenu.create({
			title: "...",
			items: [
				{title: "Items", click: "isc.Items.create({width: \"95%\", height: \"95%\"})"},
				{isSeparator: true},
				{title: "Lookups", click: "isc.Lookups.create({width: 350, height: \"95%\"})"}
			]
		});
		this.menuBar = isc.MenuBar.create({
			height: 20,
			width: 20,
			menus: [this.MainMenu]
		});
	}
});
