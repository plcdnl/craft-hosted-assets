Craft.AssetIndex.prototype.init=new Proxy(Craft.AssetIndex.prototype.init,{apply:function(t,e,a){Reflect.apply(t,e,a),e.getButtonContainer().addClass("flex")}}),Craft.AssetIndex.prototype.createUploadInputs=new Proxy(Craft.AssetIndex.prototype.createUploadInputs,{apply:function(t,e,a){var o;Reflect.apply(t,e,a),null===(o=e.$createButton)||void 0===o||o.remove(),e.$source.data("volume-handle")===Craft.HostedVideos.volumeHandle&&(e.$createButton=$("<button/>",{type:"button",class:"btn submit","data-icon":"plus",text:Craft.t("_hosted-videos","New video")}),e.getButtonContainer().prepend(e.$createButton),e.$createButton.on("click",(function(){var t={folderId:e.sourcePath[e.sourcePath.length-1].folderId};e.setIndexBusy(),Craft.sendActionRequest("POST","_hosted-videos/assets/create-hosted-video",{data:t}).then((function(t){e.setIndexAvailable(),Craft.cp.displaySuccess(Craft.t("_hosted-videos","Video created.")),e.updateElements()})).catch((function(t){var a=t.response;e.setIndexAvailable(),Craft.cp.displayError(a.data.message)}))})))}});
//# sourceMappingURL=AssetIndex.js.map