isc.defineClass("ShowInfo", "myWindow").addProperties({
	border: "0px solid black",
	initWidget: function(initData){
		this.Super("initWidget", arguments);
		this.ShowInfoDF = isc.DynamicForm.create({
			canDragResize: true,
			canEdit: false,
			fields: [{name: "detail", type: "textArea", height: "100%", width: "100%"}],
			height: "100%",
			numCols: 1,
			parent: this,
			titleOrientation: "none",
			width: "100%"
		});
		this.ShowInfoVL = isc.myVLayout.create({members: [this.ShowInfoDF]});
		this.addItem(this.ShowInfoVL);
		this.ShowInfoDF.setValue("detail", initData.info);
		this.left = initData.left;
		this.top = initData.top;
		if(initData.canEdit){
			this.ShowInfoDF.canEdit = initData.canEdit;
		}
		if(initData.autoCenter){
			this.ShowInfoDF.autoCenter = initData.autoCenter;
		}
	}
});
