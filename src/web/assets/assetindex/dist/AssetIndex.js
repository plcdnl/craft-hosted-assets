Craft.AssetIndex.prototype.init=new Proxy(Craft.AssetIndex.prototype.init,{apply:function(t,e,a){Reflect.apply(t,e,a),e.getButtonContainer().addClass("flex")}}),Craft.AssetIndex.prototype.createUploadInputs=new Proxy(Craft.AssetIndex.prototype.createUploadInputs,{apply:function(t,e,a){var o,n;Reflect.apply(t,e,a),null===(o=e.$createButton)||void 0===o||o.remove(),Craft.HostedVideos.volumeHandles.includes(e.$source.data("volume-handle"))&&(Craft.HostedVideos.hideUploadButton&&(null===(n=e.$uploadButton)||void 0===n||n.remove()),e.$createButton=$("<button/>",{type:"button",class:"btn submit","data-icon":"plus",text:Craft.t("_hosted-assets","New video")}),e.getButtonContainer().prepend(e.$createButton),e.$createButton.on("click",(function(){if(!e.$createButton.hasClass("loading")){var t={folderId:e.sourcePath[e.sourcePath.length-1].folderId},a=e.$createButton.closest(".modal").length>0;a?e.setIndexBusy():e.$createButton.addClass("loading"),Craft.sendActionRequest("POST","_hosted-assets/assets/create-hosted-video",{data:t}).then((function(t){a?(e.setIndexAvailable(),e.updateElements(),e.selectElementAfterUpdate(t.data.asset.id)):Craft.redirectTo(t.data.cpEditUrl)})).catch((function(t){var e=t.response;Craft.cp.displayError(e.data.message)})).finally((function(){a||e.$createButton.removeClass("loading")}))}})))}});
//# sourceMappingURL=AssetIndex.js.map