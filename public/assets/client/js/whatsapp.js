!function(e,a){"object"==typeof exports&&"undefined"!=typeof module?module.exports=a(require("axios"),require("fs"),require("mime")):"function"==typeof define&&define.amd?define(["axios","fs","mime"],a):(e="undefined"!=typeof globalThis?globalThis:e||self).whatsAppClient=a(e.axios,e.fs,e.mime)}(this,(function(e,a,t){"use strict";function s(e){return e&&"object"==typeof e&&"default"in e?e:{default:e}}function i(e){if(e&&e.__esModule)return e;var a=Object.create(null);return e&&Object.keys(e).forEach((function(t){if("default"!==t){var s=Object.getOwnPropertyDescriptor(e,t);Object.defineProperty(a,t,s.get?s:{enumerable:!0,get:function(){return e[t]}})}})),a.default=e,Object.freeze(a)}var n=s(e),o=i(a),r=s(a),c=s(t);class d{static validateString(e,a){if(!a||"[object String]"!==Object.prototype.toString.call(a))throw new Error(`${e} must be a String!`)}static validateInteger(e,a){if(!Number.isInteger(a))throw new Error(`${e} must be an integer!`)}static validateNumber(e,a){if(!a||!Number(a))throw new Error(`${e} must be a number!`)}static validateObject(e,a){if(!a||"[object Object]"!==Object.prototype.toString.call(a))throw new Error(`${e} must be an Object!`)}static generateMethodURL(e,a){return"sendFileByUpload"===a||"uploadFile"===a?`${e.media}/waInstance${e.idInstance}/${a}/${e.apiTokenInstance}`:`${e.host}/waInstance${e.idInstance}/${a}/${e.apiTokenInstance}`}static validateChatIdPhoneNumber(e,a){e||d.validateInteger("phoneNumber",a),a||d.validateString("chatId",e)}static validateArray(e,a){if(!a||!Array.isArray(a))throw new Error(`${e} must be an Array!`)}static validatePath(e,a){if(!a||!o.existsSync(a))throw new Error(`${e} not found!`)}}class h{constructor(e){this._restAPI=e}async sendMessage(e,a,t){d.validateChatIdPhoneNumber(e,a),d.validateString("message",t);const s={message:t};this.addChadIdParam(s,e),this.addPhoneParam(s,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendMessage"),s)).data}async sendButtons(e,a,t,s){d.validateChatIdPhoneNumber(e,void 0),d.validateString("message",a);const i={message:a,footer:t,buttons:s};this.addChadIdParam(i,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendButtons"),i)).data}async sendTemplateButtons(e,a,t=null,s){d.validateChatIdPhoneNumber(e,void 0),d.validateString("message",a);const i={message:a,templateButtons:s};null!==t&&(i.footer=t),this.addChadIdParam(i,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendTemplateButtons"),i)).data}async sendListMessage(e,a,t,s,i,o){d.validateChatIdPhoneNumber(e,void 0),d.validateString("message",a);const r={message:a,buttonText:t,title:s,footer:i,sections:o};this.addChadIdParam(r,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendListMessage"),r)).data}async sendLocation(e,a,t,s,i,o){d.validateChatIdPhoneNumber(e,a),d.validateString("nameLocation",t),d.validateString("address",s),d.validateNumber("latitude",i),d.validateNumber("longitude",o);const r={nameLocation:t,address:s,latitude:i,longitude:o};this.addChadIdParam(r,e),this.addPhoneParam(r,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendLocation"),r)).data}async sendContact(e,a,t){d.validateChatIdPhoneNumber(e,a),d.validateObject("contact",t);const s={contact:t};this.addChadIdParam(s,e),this.addPhoneParam(s,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendContact"),s)).data}async sendLink(e,a,t){d.validateChatIdPhoneNumber(e,a),d.validateString("urlLink",t);const s={urlLink:t};this.addChadIdParam(s,e),this.addPhoneParam(s,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendLink"),s)).data}async readChat(e,a,t=null){d.validateChatIdPhoneNumber(e,a);const s={idMessage:t};this.addChadIdParam(s,e),this.addPhoneParam(s,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"readChat"),s)).data}async showMessagesQueue(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"showMessagesQueue"))).data.map((e=>new l(e)))}async clearMessagesQueue(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"clearMessagesQueue"))).data}async lastIncomingMessages(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"lastIncomingMessages"))).data.map((e=>new g(e)))}async lastOutgoingMessages(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"lastOutgoingMessages"))).data.map((e=>new g(e)))}async getChatHistory(e){d.validateChatIdPhoneNumber(e,void 0);const a={chatId:e};this.addChadIdParam(a,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"getChatHistory"),a)).data}async getMessage(e,a){d.validateChatIdPhoneNumber(e,void 0),d.validateString("idMessage",a);const t={idMessage:a};this.addChadIdParam(t,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"getMessage"),t)).data}async forwardMessages(e,a,t){d.validateString("chatId",e),d.validateString("chatIdFrom",a),d.validateArray("messages",t);const s={chatId:e,chatIdFrom:a,messages:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"ForwardMessages"),s)).data}addChadIdParam(e,a){a&&(e.chatId=a)}addPhoneParam(e,a){a&&(e.chatId=`${a}@c.us`)}}class g{constructor(e){this.chatId=e.chatId,this.idMessage=e.idMessage,this.statusMessage=e.statusMessage,this.textMessage=e.textMessage,this.timestamp=e.timestamp,this.typeMessage=e.typeMessage}}class l{constructor(e){this.chatId=e.chatId,this.fileName=e.fileName,this.typeMessage=e.typeMessage}}class u{constructor(e){this._restAPI=e}async sendFileByUrl(e,a,t,s,i=""){d.validateChatIdPhoneNumber(e,a),d.validateString("urlFile",t),d.validateString("filename",s);const o={urlFile:t,fileName:s,caption:i};this.addChadIdParam(o,e),this.addPhoneParam(o,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"sendFileByUrl"),o)).data}async uploadFile(e){d.validateString("filePath",e);const a=r.default.readFileSync(e);return(await n.default({method:"post",url:d.generateMethodURL(this._restAPI.params,"uploadFile"),data:a,headers:{"Content-Type":c.default.getType(e)}})).data}async sendFileByUpload(e){return(await n.default({method:"post",url:d.generateMethodURL(this._restAPI.params,"sendFileByUpload"),data:e,headers:e.getHeaders()})).data}async downloadFile(e,a){d.validateChatIdPhoneNumber(e,void 0),d.validateString("message",a);const t={idMessage:a};this.addChadIdParam(t,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"downloadFile"),t)).data}addChadIdParam(e,a){a&&(e.chatId=a)}addPhoneParam(e,a){a&&(e.phoneNumber=a)}}class p{constructor(e){this._restAPI=e}async qr(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"qr"))).data}async logout(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"logout"))).data}async reboot(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"reboot"))).data}async getStateInstance(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"getStateInstance"))).data}async getDeviceInfo(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"getDeviceInfo"))).data}async checkWhatsapp(e){d.validateInteger("phoneNumber",e);const a={phoneNumber:e};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"checkWhatsapp"),a)).data}async getAvatar(e,a){d.validateChatIdPhoneNumber(e,a);const t={};this.addChadIdParam(t,e),this.addPhoneParam(t,a);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"getAvatar"),t)).data}async archiveChat(e){d.validateChatIdPhoneNumber(e,void 0);const a={};this.addChadIdParam(a,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"archiveChat"),a)).data}async unarchiveChat(e){d.validateChatIdPhoneNumber(e,void 0);const a={};this.addChadIdParam(a,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"unarchiveChat"),a)).data}async getContactInfo(e){d.validateChatIdPhoneNumber(e,void 0);const a={};this.addChadIdParam(a,e);return(await n.default.post(d.generateMethodURL(this._restAPI.params,"getContactInfo"),a)).data}async getContacts(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"getContacts"))).data}async getChats(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"getChats"))).data}addChadIdParam(e,a){a&&(e.chatId=a)}addPhoneParam(e,a){a&&(e.phoneNumber=a)}}class m{constructor(e){this._restAPI=e}async getSettings(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"getSettings"))).data}async setSettings(e){d.validateObject("settings",e);const a=e;return(await n.default.post(d.generateMethodURL(this._restAPI.params,"setSettings"),a)).data}}class v{constructor(e){this._restAPI=e}async createGroup(e,a,t){d.validateString("groupName",e),d.validateArray("chatIds",a),d.validateArray("phones",t);const s={groupName:e,chatIds:a,phones:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"createGroup"),s)).data}async addGroupParticipant(e,a,t){d.validateString("groupId",e),d.validateChatIdPhoneNumber(a,t);const s={groupId:e,participantChatId:a,participantPhone:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"addGroupParticipant"),s)).data}async getGroupData(e){d.validateString("groupId",e);const a={groupId:e};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"getGroupData"),a)).data}async removeGroupParticipant(e,a,t){d.validateString("groupId",e),d.validateChatIdPhoneNumber(a,t);const s={groupId:e,participantChatId:a,participantPhone:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"removeGroupParticipant"),s)).data}async updateGroupName(e,a){d.validateString("groupId",e),d.validateString("groupName",a);const t={groupId:e,groupName:a};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"updateGroupName"),t)).data}async setGroupAdmin(e,a,t){d.validateString("groupId",e);const s={groupId:e,participantChatId:a,participantPhone:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"setGroupAdmin"),s)).data}async removeAdmin(e,a,t){d.validateString("groupId",e);const s={groupId:e,participantChatId:a,participantPhone:t};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"removeAdmin"),s)).data}async leaveGroup(e){d.validateString("groupId",e);const a={groupId:e};return(await n.default.post(d.generateMethodURL(this._restAPI.params,"removeAdmin"),a)).data}}class I{initJobs(e=[]){this.jobs=e}reschedule(){this.jobs.forEach((e=>{e.needInterrupt=!1,clearInterval(e.timerId),e.timerId=setInterval(e.run,1e3*e.intervalSec)}))}unschedule(){this.jobs.forEach((e=>{e.needInterrupt=!0,clearInterval(e.timerId)}))}}class M{timerId;intervalSec;needInterrupt=!1;constructor(e){this.webhookServiceApi=e,this.intervalSec=Number.parseInt("1")}run=async()=>{clearInterval(this.timerId);try{let e;for(;e=await this.webhookServiceApi.receiveNotification();){let a=e.body;a.typeWebhook===this.webhookServiceApi.noteTypes.incomingMessageReceived?"imageMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageImage,a):"videoMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageVideo,a):"documentMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageDocument,a):"audioMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageAudio,a):"documentMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageDocument,a):"textMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageText,a):"extendedTextMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageTextURL,a):"contactMessage"==a.messageData.typeMessage?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageContact,a):"locationMessage"==a.messageData.typeMessage&&this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingMessageLocation,a):a.typeWebhook===this.webhookServiceApi.noteTypes.stateInstanceChanged?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingAccountStatus,a):a.typeWebhook===this.webhookServiceApi.noteTypes.outgoingMessageStatus?this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingOutboundMessageStatus,a):a.typeWebhook===this.webhookServiceApi.noteTypes.deviceInfo&&this.callCallback(this.webhookServiceApi.callbackTypes.onReceivingDeviceStatus,a),await this.webhookServiceApi.deleteNotification(e.receiptId)}}catch(e){console.error(e.toString())}this.needInterrupt||(this.timerId=setInterval(this.run,1e3*this.intervalSec))};callCallback(e,a){const t=this.webhookServiceApi._callbacks.get(e);t&&t.call(this,a)}}class b{constructor(e){this._restAPI=e,this._jobScheduler=new I,this.noteTypes={incomingMessageReceived:"incomingMessageReceived",outgoingMessageStatus:"outgoingMessageStatus",stateInstanceChanged:"stateInstanceChanged",deviceInfo:"deviceInfo"},this.callbackTypes={onReceivingMessageText:"onReceivingMessageText",onReceivingMessageImage:"onReceivingMessageImage",onReceivingMessageVideo:"onReceivingMessageVideo",onReceivingMessageDocument:"onReceivingMessageDocument",onReceivingMessageAudio:"onReceivingMessageAudio",onReceivingOutboundMessageStatus:"onReceivingOutboundMessageStatus",onReceivingAccountStatus:"onReceivingAccountStatus",onReceivingDeviceStatus:"onReceivingDeviceStatus",onReceivingMessageTextURL:"onReceivingMessageTextURL",onReceivingMessageContact:"onReceivingMessageContact",onReceivingMessageLocation:"onReceivingMessageLocation"},this._callbacks=new Map}async receiveNotification(){return(await n.default.get(d.generateMethodURL(this._restAPI.params,"receiveNotification"))).data}async deleteNotification(e){d.validateInteger("receiptId",e);return(await n.default.delete(`${d.generateMethodURL(this._restAPI.params,"deleteNotification")}/${e}`)).data}async startReceivingNotifications(){this._jobScheduler.initJobs([new M(this)]),this._jobScheduler.reschedule()}async stopReceivingNotifications(){this._jobScheduler.unschedule()}onReceivingMessageText(e){this._callbacks.set(this.callbackTypes.onReceivingMessageText,e)}onReceivingMessageImage(e){this._callbacks.set(this.callbackTypes.onReceivingMessageImage,e)}onReceivingMessageVideo(e){this._callbacks.set(this.callbackTypes.onReceivingMessageVideo,e)}onReceivingMessageDocument(e){this._callbacks.set(this.callbackTypes.onReceivingMessageDocument,e)}onReceivingMessageAudio(e){this._callbacks.set(this.callbackTypes.onReceivingMessageAudio,e)}onReceivingOutboundMessageStatus(e){this._callbacks.set(this.callbackTypes.onReceivingOutboundMessageStatus,e)}onReceivingAccountStatus(e){this._callbacks.set(this.callbackTypes.onReceivingAccountStatus,e)}onReceivingDeviceStatus(e){this._callbacks.set(this.callbackTypes.onReceivingDeviceStatus,e)}onReceivingMessageTextURL(e){this._callbacks.set(this.callbackTypes.onReceivingMessageTextURL,e)}onReceivingMessageContact(e){this._callbacks.set(this.callbackTypes.onReceivingMessageContact,e)}onReceivingMessageLocation(e){this._callbacks.set(this.callbackTypes.onReceivingMessageLocation,e)}}class y{constructor(e){this.params={host:"",media:"",idInstance:"",apiTokenInstance:"",credentialsPath:null},Object.assign(this.params,e),e.credentialsPath&&o.readFileSync(e.credentialsPath).toString("utf8").split("\n").map((e=>e.split(" ").join(""))).forEach((e=>{e.startsWith("API_TOKEN_INSTANCE=")?this.params.apiTokenInstance=e.replace("API_TOKEN_INSTANCE=","").trim():e.startsWith("ID_INSTANCE=")&&(this.params.idInstance=e.replace("ID_INSTANCE=","").trim())})),this.message=new h(this),this.file=new u(this),this.instance=new p(this),this.settings=new m(this),this.group=new v(this),this.webhookService=new b(this)}}var P="https://api.green-api.com",R="https://media.green-api.com";class f{constructor(e,a){this._app=e,this._webhookRoutePath=a,this._callbacks=new Map}init(){this._app.post(this._webhookRoutePath,(async(e,a,t)=>{try{console.log(`Received webhook ${e.body.typeWebhook}`);let t=null;t=e.body.messageData&&e.body.messageData.typeMessage?`${e.body.typeWebhook}_${e.body.messageData.typeMessage}`:e.body.typeWebhook;const s=this._callbacks.get(t);return s&&s.call(this,e.body),a.send()}catch(e){t(e)}}))}onStateInstance(e){this._callbacks.set("stateInstanceChanged",e)}onOutgoingMessageStatus(e){this._callbacks.set("outgoingMessageStatus",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.status)}))}onIncomingMessageText(e){this._callbacks.set("incomingMessageReceived_textMessage",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.senderData.sender,a.messageData.typeMessage,a.messageData.textMessageData.textMessage)}))}onIncomingMessageFile(e){this._callbacks.set("incomingMessageReceived_imageMessage",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.senderData.sender,a.messageData.typeMessage,a.messageData.downloadUrl)}))}onIncomingMessageLocation(e){this._callbacks.set("incomingMessageReceived_locationMessage",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.senderData.sender,a.messageData.typeMessage,a.messageData.locationMessageData.latitude,a.messageData.locationMessageData.longitude,a.messageData.locationMessageData.jpegThumbnail)}))}onIncomingMessageContact(e){this._callbacks.set("incomingMessageReceived_contactMessage",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.senderData.sender,a.messageData.typeMessage,a.messageData.contactMessageData.displayName,a.messageData.contactMessageData.vcard)}))}onIncomingMessageExtendedText(e){this._callbacks.set("incomingMessageReceived_extendedTextMessage",(a=>{e.call(this,a,a.instanceData.idInstance,a.idMessage,a.senderData.sender,a.messageData.typeMessage,a.extendedTextMessageData)}))}onDeviceInfo(e){this._callbacks.set("deviceInfo",e)}}return{restAPI:(e={})=>(function(e={}){e.host?d.validateString("host",e.host):e.host=P,e.media?d.validateString("media",e.media):e.media=R,e.credentialsPath?d.validatePath("credentialsPath",e.credentialsPath):(d.validateString("idInstance",e.idInstance),d.validateString("apiTokenInstance",e.apiTokenInstance))}(e),new y(e)),webhookAPI:(e,a)=>{const t=new f(e,a);return t.init(),t}}}));