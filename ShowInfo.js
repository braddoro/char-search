isc.defineClass("ShowInfo", "myWindow").addProperties({
	// autoCenter: true,
	border: "0px solid black",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ShowInfoDF = isc.DynamicForm.create({
			parent: this,
			canDragResize: true,
			canEdit: false,
			height: "100%",
			width: "100%",
			numCols: 1,
			titleOrientation: "none",
			fields: [
				{name: "detail", type: "textArea", height: "100%", width: "100%"}
			]
		});
		this.ShowInfoVL = isc.myVLayout.create({members: [this.ShowInfoDF]});
		this.addItem(this.ShowInfoVL);
		this.ShowInfoDF.setValue("detail", initData.info);
		this.left = initData.left;
		this.top = initData.top;
	}
});
