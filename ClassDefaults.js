isc.defineClass("myWindow", "Window").addProperties({
	showCorner: true,
	// useTouchScrolling: true,
	showMaximizeButton: true,
	canDragReposition: true,
	keepInParentRect: true,
	dismissOnEscape: false,
	canDragResize: true,
	edgeMarginSize: 5,
	showShadow: true,
	defaultHeight: 300,
	defaultWidth: 485,
	// height: 200,
	// width: 200,
	// overflow: "auto",
	// leaveScrollbarGap: true,
	title: "",
	left: 25,
	top: 25
	// resized: function(){
	// 	console.log("Title.: " + this.title);
	// 	console.log("Width.: " + this.width);
	// 	console.log("Height: " + this.height);
	// 	console.log("Left..: " + this.left);
	// 	console.log("Top...: " + this.top);
	// }
	// moved: function(){
	// 	// console.log("Title.: " + this.title);
	// 	// console.log("Width.: " + this.width);
	// 	// console.log("Height: " + this.height);
	// 	// console.log("Left..: " + this.left);
	// 	// console.log("Top...: " + this.top);
	// }
});
isc.defineClass("myVLayout", "VLayout").addProperties({
	height: "100%"
});
isc.defineClass("myHLayout", "HLayout").addProperties({
	//width: "99%"
});
isc.defineClass("myListGrid", "ListGrid").addProperties({
	alternateRecordStyles: true,
	autoFitFieldWidths: true,
	autoFitWidthApproach: 'title',
	canDragResize: true,
	leaveScrollbarGap: false,
	left: 5,
	selectionStyle: "single",
	shadowOffset: 3,
	shadowSoftness: 7,
	// autoFitData: "both"
	showAllRecords: true,
	showShadow: true,
	height: 150,
	// width: 650,
	dataArrived: function(startRow, endRow){
		this.selectSingleRecord(startRow);
		this.recordClick(this, startRow, startRow);
	}
});
isc.defineClass("myDataSource", "DataSource").addProperties({
	dataFormat: "json",
	operationBindings:[{operationType:"fetch", dataProtocol:"postParams"}]
	// willHandleError: true
	// handleError: function(response, request){
	// 	isc.warn('sadfsadfsdf');
	// 	return true;
	// }
});
isc.defineClass("myLabel", "Label").addProperties({
	valign: "top",
	margin: 2,
	baseStyle: "headerItem",
	height: 1,
	width: 500
});
isc.defineClass("myMenu", "Menu").addProperties({
	showIcons: false,
	shadowDepth: 10,
	cellHeight: 16,
	width: 24
});
isc.defineClass("myIButton", "IButton").addProperties({
	autoFit: true
});
