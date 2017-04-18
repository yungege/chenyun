define("common:widget/view/parsestl.js",function(t,e){var r=t("common:widget/lib/three.js"),n=t("common:widget/view/support.js"),o={parse:function(t){var e=function(){var t,e,n,o;if(o=new DataView(r),e=50,n=o.getUint32(80,!0),t=84+n*e,(o.byteLength-84)/50===0)return!0;for(var a=o.byteLength,i=0;a>i;i++)if(o.getUint8(i,!1)>127)return!0;return!1},r=this.ensureBinary(t);return e()?this.parseBinary(r):this.parseASCII(this.ensureString(t))},parseBinary:function(t){for(var e,n,o,a,i,s,u,h,f=new DataView(t),c=f.getUint32(80,!0),p=!1,l=0;70>l;l++)1129270351==f.getUint32(l,!1)&&82==f.getUint8(l+4)&&61==f.getUint8(l+5)&&(p=!0,a=new Float32Array(3*c*3),i=f.getUint8(l+6)/255,s=f.getUint8(l+7)/255,u=f.getUint8(l+8)/255,h=f.getUint8(l+9)/255);for(var d=84,g=50,w=0,v=new r.THREE.BufferGeometry,y=new Float32Array(3*c*3),E=new Float32Array(3*c*3),_=0;c>_;_++){var F=d+_*g,b=f.getFloat32(F,!0),B=f.getFloat32(F+4,!0),I=f.getFloat32(F+8,!0);if(p){var U=f.getUint16(F+48,!0);0===(32768&U)?(e=(31&U)/31,n=(U>>5&31)/31,o=(U>>10&31)/31):(e=i,n=s,o=u)}for(var m=1;3>=m;m++){var A=F+12*m;y[w]=f.getFloat32(A,!0),y[w+1]=f.getFloat32(A+4,!0),y[w+2]=f.getFloat32(A+8,!0),E[w]=b,E[w+1]=B,E[w+2]=I,p&&(a[w]=e,a[w+1]=n,a[w+2]=o),w+=3}}w=0;var S=function(t,e){var r=0,n=t.length;for(var o in t)0===parseInt(t[o],10)&&r++;if(r!=n)return t;for(var a,i,s,u,h,f,p=new Float32Array(3*c*3),l=0,d=0,g=0,o=0;o<e.length;o+=9){a=e[o+3]-e[o],i=e[o+4]-e[o+1],s=e[o+5]-e[o+2],u=e[o+6]-e[o],h=e[o+7]-e[o+1],f=e[o+8]-e[o+2],l=f*i-h*s,d=a*f-u*s,g=a*h-u*i;for(var v=0;3>v;v++)p[w]=l,p[w+1]=d,p[w+2]=g,w+=3}return p};return E=S(E,y),v.addAttribute("position",new r.THREE.BufferAttribute(y,3)),v.addAttribute("normal",new r.THREE.BufferAttribute(E,3)),p&&(v.addAttribute("color",new r.THREE.BufferAttribute(a,3)),v.hasColors=!0,v.alpha=h),v},parseASCII:function(t){var e,n,o,a,i,s,u,h;for(e=new r.THREE.Geometry,a=/facet([\s\S]*?)endfacet/g;null!==(u=a.exec(t));){for(h=u[0],i=/normal[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;null!==(u=i.exec(h));)o=new r.THREE.Vector3(parseFloat(u[1]),parseFloat(u[3]),parseFloat(u[5]));for(s=/vertex[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;null!==(u=s.exec(h));)e.vertices.push(new r.THREE.Vector3(parseFloat(u[1]),parseFloat(u[3]),parseFloat(u[5])));n=e.vertices.length,e.faces.push(new r.THREE.Face3(n-3,n-2,n-1,o))}return e.computeBoundingBox(),e.computeBoundingSphere(),e},ensureString:function(t){if("string"!=typeof t){for(var e=new Uint8Array(t),r="",n=0;n<t.byteLength;n++)r+=String.fromCharCode(e[n]);return r}return t},ensureBinary:function(t){if("string"==typeof t){for(var e=new Uint8Array(t.length),r=0;r<t.length;r++)e[r]=255&t.charCodeAt(r);return e.buffer||e}return t}},a=function(t){this._buffer=t,this._pos=0};a.prototype={readInt8:function(){return this._decodeInt(8,!0)},readUInt8:function(){return this._decodeInt(8,!1)},readInt16:function(){return this._decodeInt(16,!0)},readUInt16:function(){return this._decodeInt(16,!1)},readInt32:function(){return this._decodeInt(32,!0)},readUInt32:function(){return this._decodeInt(32,!1)},readFloat:function(){return this._decodeFloat(23,8)},readDouble:function(){return this._decodeFloat(52,11)},readChar:function(){return this.readString(1)},readString:function(t){this._checkSize(8*t);var e=this._buffer.substr(this._pos,t);return this._pos+=t,e},seek:function(t){this._pos=t,this._checkSize(0)},getPosition:function(){return this._pos},getSize:function(){return this._buffer.length},_decodeFloat:function(t,e){var r=t+e+1,n=r>>3;this._checkSize(r);var o=Math.pow(2,e-1)-1,a=this._readBits(t+e,1,n),i=this._readBits(t,e,n),s=0,u=2,h=0;do for(var f=this._readByte(++h,n),c=t%8||8,p=1<<c;p>>=1;)f&p&&(s+=1/u),u*=2;while(t-=c);return this._pos+=n,i==(o<<1)+1?s?0/0:a?-1/0:+1/0:(1+-2*a)*(i||s?i?Math.pow(2,i-o)*(1+s):Math.pow(2,-o+1)*s:0)},_decodeInt:function(t,e){var r=this._readBits(0,t,t/8),n=Math.pow(2,t),o=e&&r>=n/2?r-n:r;return this._pos+=t/8,o},_shl:function(t,e){for(++e;--e;t=1073741824==(1073741824&(t%=2147483648))?2*t:2*(t-1073741824)+2147483647+1);return t},_readByte:function(t,e){return 255&this._buffer.charCodeAt(this._pos+e-t-1)},_readBits:function(t,e,r){var n=(t+e)%8,o=t%8,a=r-(t>>3)-1,i=r+(-(t+e)>>3),s=a-i,u=this._readByte(a,r)>>o&(1<<(s?8-o:e))-1;for(s&&n&&(u+=(this._readByte(i++,r)&(1<<n)-1)<<(s--<<3)-o);s;)u+=this._shl(this._readByte(i++,r),(s--<<3)-o);return u},_checkSize:function(t){if(!(this._pos+Math.ceil(t/8)<this._buffer.length))throw new Error("Index out of bound")}};var i={parse:function(t){var e=function(t){return t.indexOf("facet")>-1?!1:!0};return e(t)?this.parseBinary(t):this.parseASCII(t)},parseBinary:function(t){var e,n,o,i=0,s=new r.THREE.Geometry,u=new a(t);for(u.seek(80),e=u.readUInt32(),i=0;e>i;i++){var h=[u.readFloat(),u.readFloat(),u.readFloat()],f=[u.readFloat(),u.readFloat(),u.readFloat()],c=[u.readFloat(),u.readFloat(),u.readFloat()],p=[u.readFloat(),u.readFloat(),u.readFloat()],l=function(){var t=0;for(var e in h)0===parseInt(h[e],10)&&t++;if(3!=t)return h;var r,n,o,a,i,s,u=[],l=0,d=0,g=0;return r=c[0]-f[0],n=c[1]-f[1],o=c[2]-f[2],a=p[0]-f[0],i=p[1]-f[1],s=p[2]-f[2],l=s*n-i*o,d=r*s-a*o,g=r*i-a*n,u.push(l),u.push(d),u.push(g),u};h=l(),o=new r.THREE.Vector3(h[0],h[1],h[2]),s.vertices.push(new r.THREE.Vector3(f[0],f[1],f[2])),s.vertices.push(new r.THREE.Vector3(c[0],c[1],c[2])),s.vertices.push(new r.THREE.Vector3(p[0],p[1],p[2])),u.readUInt16(),n=s.vertices.length,s.faces.push(new r.THREE.Face3(n-3,n-2,n-1,o))}return s.computeBoundingBox(),s.computeBoundingSphere(),s},parseASCII:function(t){var e,n,o,a,i,s,u,h;for(e=new r.THREE.Geometry,a=/facet([\s\S]*?)endfacet/g;null!=(u=a.exec(t));){for(h=u[0],i=/normal[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;null!=(u=i.exec(h));)o=new r.THREE.Vector3(parseFloat(u[1]),parseFloat(u[3]),parseFloat(u[5]));for(s=/vertex[\s]+([\-+]?[0-9]+\.?[0-9]*([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+[\s]+([\-+]?[0-9]*\.?[0-9]+([eE][\-+]?[0-9]+)?)+/g;null!=(u=s.exec(h));)e.vertices.push(new r.THREE.Vector3(parseFloat(u[1]),parseFloat(u[3]),parseFloat(u[5])));n=e.vertices.length,e.faces.push(new r.THREE.Face3(n-3,n-2,n-1,o))}return e.computeBoundingBox(),e.computeBoundingSphere(),e}},s={parse:function(t){return n.support.checkXhr2()?(console.log("parse stl use arraybuffer"),o.parse(t)):(console.log("parse stl use text/plain"),i.parse(t))}};"undefined"==typeof DataView&&(DataView=function(t,e,r){this.buffer=t,this.byteOffset=e||0,this.byteLength=r||t.byteLength||t.length,this._isString="string"==typeof t},DataView.prototype={_getCharCodes:function(t,e,r){e=e||0,r=r||t.length;for(var n=e+r,o=[],a=e;n>a;a++)o.push(255&t.charCodeAt(a));return o},_getBytes:function(t,e,r){var n;if(void 0===r&&(r=this._littleEndian),e=void 0===e?this.byteOffset:this.byteOffset+e,void 0===t&&(t=this.byteLength-e),"number"!=typeof e)throw new TypeError("DataView byteOffset is not a number");if(0>t||e+t>this.byteLength)throw new Error("DataView length or (byteOffset+length) value is out of bounds");return n=this.isString?this._getCharCodes(this.buffer,e,e+t):this.buffer.slice(e,e+t),!r&&t>1&&(Array.isArray(n)===!1&&(n=Array.prototype.slice.call(n)),n.reverse()),n},getFloat64:function(t,e){var r=this._getBytes(8,t,e),n=1-2*(r[7]>>7),o=((r[7]<<1&255)<<3|r[6]>>4)-1023,a=(15&r[6])*Math.pow(2,48)+r[5]*Math.pow(2,40)+r[4]*Math.pow(2,32)+r[3]*Math.pow(2,24)+r[2]*Math.pow(2,16)+r[1]*Math.pow(2,8)+r[0];return 1024===o?0!==a?0/0:1/0*n:-1023===o?n*a*Math.pow(2,-1074):n*(1+a*Math.pow(2,-52))*Math.pow(2,o)},getFloat32:function(t,e){var r=this._getBytes(4,t,e),n=1-2*(r[3]>>7),o=(r[3]<<1&255|r[2]>>7)-127,a=(127&r[2])<<16|r[1]<<8|r[0];return 128===o?0!==a?0/0:1/0*n:-127===o?n*a*Math.pow(2,-149):n*(1+a*Math.pow(2,-23))*Math.pow(2,o)},getInt32:function(t,e){var r=this._getBytes(4,t,e);return r[3]<<24|r[2]<<16|r[1]<<8|r[0]},getUint32:function(t,e){return this.getInt32(t,e)>>>0},getInt16:function(t,e){return this.getUint16(t,e)<<16>>16},getUint16:function(t,e){var r=this._getBytes(2,t,e);return r[1]<<8|r[0]},getInt8:function(t){return this.getUint8(t)<<24>>24},getUint8:function(t){return this._getBytes(1,t)[0]}}),e.parsestl=s});