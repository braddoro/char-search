isc.defineClass("Desktop", "Canvas").addProperties({
	initWidget: function (initData) {
		this.Super("initWidget", initData);
		this.deskMenu = isc.Navigation.create();
		this.addMethods(this.deskMenu);
		isc.ShowInfo.create({title: "Notes", info: initData.data, width: "33%", top: 100, left: 100});
	}
});
