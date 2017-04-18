define("common:widget/lib/cbd.js",function(t,e){var i=function(t,e){i={FRONT:0,BACK:1,DOUBLE:2,SVGNS:"http://www.w3.org/2000/svg"},i.Array="function"==typeof Float32Array?Float32Array:Array,i.Utils={isNumber:function(t){return!isNaN(parseFloat(t))&&isFinite(t)}},function(){for(var t=0,e=["ms","moz","webkit","o"],i=0;i<e.length&&!window.requestAnimationFrame;++i)window.requestAnimationFrame=window[e[i]+"RequestAnimationFrame"],window.cancelAnimationFrame=window[e[i]+"CancelAnimationFrame"]||window[e[i]+"CancelRequestAnimationFrame"];window.requestAnimationFrame||(window.requestAnimationFrame=function(e){var i=(new Date).getTime(),r=Math.max(0,16-(i-t)),n=window.setTimeout(function(){e(i+r)},r);return t=i+r,n}),window.cancelAnimationFrame||(window.cancelAnimationFrame=function(t){clearTimeout(t)})}(),Math.PIM2=2*Math.PI,Math.PID2=Math.PI/2,Math.randomInRange=function(t,e){return t+(e-t)*Math.random()},Math.clamp=function(t,e,i){return t=Math.max(t,e),t=Math.min(t,i)},i.Vector3={create:function(t,e,r){var n=new i.Array(3);return this.set(n,t,e,r),n},clone:function(t){var e=this.create();return this.copy(e,t),e},set:function(t,e,i,r){return t[0]=e||0,t[1]=i||0,t[2]=r||0,this},setX:function(t,e){return t[0]=e||0,this},setY:function(t,e){return t[1]=e||0,this},setZ:function(t,e){return t[2]=e||0,this},copy:function(t,e){return t[0]=e[0],t[1]=e[1],t[2]=e[2],this},add:function(t,e){return t[0]+=e[0],t[1]+=e[1],t[2]+=e[2],this},addVectors:function(t,e,i){return t[0]=e[0]+i[0],t[1]=e[1]+i[1],t[2]=e[2]+i[2],this},addScalar:function(t,e){return t[0]+=e,t[1]+=e,t[2]+=e,this},subtract:function(t,e){return t[0]-=e[0],t[1]-=e[1],t[2]-=e[2],this},subtractVectors:function(t,e,i){return t[0]=e[0]-i[0],t[1]=e[1]-i[1],t[2]=e[2]-i[2],this},subtractScalar:function(t,e){return t[0]-=e,t[1]-=e,t[2]-=e,this},multiply:function(t,e){return t[0]*=e[0],t[1]*=e[1],t[2]*=e[2],this},multiplyVectors:function(t,e,i){return t[0]=e[0]*i[0],t[1]=e[1]*i[1],t[2]=e[2]*i[2],this},multiplyScalar:function(t,e){return t[0]*=e,t[1]*=e,t[2]*=e,this},divide:function(t,e){return t[0]/=e[0],t[1]/=e[1],t[2]/=e[2],this},divideVectors:function(t,e,i){return t[0]=e[0]/i[0],t[1]=e[1]/i[1],t[2]=e[2]/i[2],this},divideScalar:function(t,e){return 0!==e?(t[0]/=e,t[1]/=e,t[2]/=e):(t[0]=0,t[1]=0,t[2]=0),this},cross:function(t,e){var i=t[0],r=t[1],n=t[2];return t[0]=r*e[2]-n*e[1],t[1]=n*e[0]-i*e[2],t[2]=i*e[1]-r*e[0],this},crossVectors:function(t,e,i){return t[0]=e[1]*i[2]-e[2]*i[1],t[1]=e[2]*i[0]-e[0]*i[2],t[2]=e[0]*i[1]-e[1]*i[0],this},min:function(t,e){return t[0]<e&&(t[0]=e),t[1]<e&&(t[1]=e),t[2]<e&&(t[2]=e),this},max:function(t,e){return t[0]>e&&(t[0]=e),t[1]>e&&(t[1]=e),t[2]>e&&(t[2]=e),this},clamp:function(t,e,i){return this.min(t,e),this.max(t,i),this},limit:function(t,e,i){var r=this.length(t);return null!==e&&e>r?this.setLength(t,e):null!==i&&r>i&&this.setLength(t,i),this},dot:function(t,e){return t[0]*e[0]+t[1]*e[1]+t[2]*e[2]},normalise:function(t){return this.divideScalar(t,this.length(t))},negate:function(t){return this.multiplyScalar(t,-1)},distanceSquared:function(t,e){var i=t[0]-e[0],r=t[1]-e[1],n=t[2]-e[2];return i*i+r*r+n*n},distance:function(t,e){return Math.sqrt(this.distanceSquared(t,e))},lengthSquared:function(t){return t[0]*t[0]+t[1]*t[1]+t[2]*t[2]},length:function(t){return Math.sqrt(this.lengthSquared(t))},setLength:function(t,e){var i=this.length(t);return 0!==i&&e!==i&&this.multiplyScalar(t,e/i),this}},i.Vector4={create:function(t,e,r,n){return n=new i.Array(4),this.set(n,t,e,r),n},set:function(t,e,i,r,n){return t[0]=e||0,t[1]=i||0,t[2]=r||0,t[3]=n||0,this},setX:function(t,e){return t[0]=e||0,this},setY:function(t,e){return t[1]=e||0,this},setZ:function(t,e){return t[2]=e||0,this},setW:function(t,e){return t[3]=e||0,this},add:function(t,e){return t[0]+=e[0],t[1]+=e[1],t[2]+=e[2],t[3]+=e[3],this},multiplyVectors:function(t,e,i){return t[0]=e[0]*i[0],t[1]=e[1]*i[1],t[2]=e[2]*i[2],t[3]=e[3]*i[3],this},multiplyScalar:function(t,e){return t[0]*=e,t[1]*=e,t[2]*=e,t[3]*=e,this},min:function(t,e){return t[0]<e&&(t[0]=e),t[1]<e&&(t[1]=e),t[2]<e&&(t[2]=e),t[3]<e&&(t[3]=e),this},max:function(t,e){return t[0]>e&&(t[0]=e),t[1]>e&&(t[1]=e),t[2]>e&&(t[2]=e),t[3]>e&&(t[3]=e),this},clamp:function(t,e,i){return this.min(t,e),this.max(t,i),this}},i.Color=function(t,e){this.rgba=i.Vector4.create(),this.hex=t||"#000000",this.opacity=i.Utils.isNumber(e)?e:1,this.set(this.hex,this.opacity)},i.Color.prototype={set:function(t,e){t=t.replace("#","");var r=t.length/3;return this.rgba[0]=parseInt(t.substring(0*r,1*r),16)/255,this.rgba[1]=parseInt(t.substring(1*r,2*r),16)/255,this.rgba[2]=parseInt(t.substring(2*r,3*r),16)/255,this.rgba[3]=i.Utils.isNumber(e)?e:this.rgba[3],this},hexify:function(t){return t=Math.ceil(255*t).toString(16),1===t.length&&(t="0"+t),t},format:function(){var t=this.hexify(this.rgba[0]),e=this.hexify(this.rgba[1]),i=this.hexify(this.rgba[2]);return this.hex="#"+t+e+i}},i.Object=function(){this.position=i.Vector3.create()},i.Object.prototype={setPosition:function(t,e,r){return i.Vector3.set(this.position,t,e,r),this}},i.Light=function(t,e){i.Object.call(this),this.ambient=new i.Color(t||"#FFFFFF"),this.diffuse=new i.Color(e||"#FFFFFF"),this.ray=i.Vector3.create()},i.Light.prototype=Object.create(i.Object.prototype),i.Vertex=function(t,e,r){this.position=i.Vector3.create(t,e,r)},i.Vertex.prototype={setPosition:function(t,e,r){return i.Vector3.set(this.position,t,e,r),this}},i.Triangle=function(t,e,r){this.a=t||new i.Vertex,this.b=e||new i.Vertex,this.c=r||new i.Vertex,this.vertices=[this.a,this.b,this.c],this.u=i.Vector3.create(),this.v=i.Vector3.create(),this.centroid=i.Vector3.create(),this.normal=i.Vector3.create(),this.color=new i.Color,this.polygon=document.createElementNS(i.SVGNS,"polygon"),this.polygon.setAttributeNS(null,"stroke-linejoin","round"),this.polygon.setAttributeNS(null,"stroke-miterlimit","1"),this.polygon.setAttributeNS(null,"stroke-width","1"),this.computeCentroid(),this.computeNormal()},i.Triangle.prototype={computeCentroid:function(){return this.centroid[0]=this.a.position[0]+this.b.position[0]+this.c.position[0],this.centroid[1]=this.a.position[1]+this.b.position[1]+this.c.position[1],this.centroid[2]=this.a.position[2]+this.b.position[2]+this.c.position[2],i.Vector3.divideScalar(this.centroid,3),this},computeNormal:function(){return i.Vector3.subtractVectors(this.u,this.b.position,this.a.position),i.Vector3.subtractVectors(this.v,this.c.position,this.a.position),i.Vector3.crossVectors(this.normal,this.u,this.v),i.Vector3.normalise(this.normal),this}},i.Geometry=function(){this.vertices=[],this.triangles=[],this.dirty=!1},i.Geometry.prototype={update:function(){if(this.dirty){var t,e;for(t=this.triangles.length-1;t>=0;t--)e=this.triangles[t],e.computeCentroid(),e.computeNormal();this.dirty=!1}return this}},i.Plane=function(t,e,r,n){i.Geometry.call(this),this.width=t||100,this.height=e||100,this.segments=r||4,this.slices=n||4,this.segmentWidth=this.width/this.segments,this.sliceHeight=this.height/this.slices;var s,o,a;for(r=[],s=-.5*this.width,o=.5*this.height,t=0;t<=this.segments;t++)for(r.push([]),e=0;e<=this.slices;e++)n=new i.Vertex(s+t*this.segmentWidth,o-e*this.sliceHeight),r[t].push(n),this.vertices.push(n);for(t=0;t<this.segments;t++)for(e=0;e<this.slices;e++)n=r[t+0][e+0],s=r[t+0][e+1],o=r[t+1][e+0],a=r[t+1][e+1],t0=new i.Triangle(n,s,o),t1=new i.Triangle(o,s,a),this.triangles.push(t0,t1)},i.Plane.prototype=Object.create(i.Geometry.prototype),i.Material=function(t,e){this.ambient=new i.Color(t||"#444444"),this.diffuse=new i.Color(e||"#FFFFFF"),this.slave=new i.Color},i.Mesh=function(t,e){i.Object.call(this),this.geometry=t||new i.Geometry,this.material=e||new i.Material,this.side=i.FRONT,this.visible=!0},i.Mesh.prototype=Object.create(i.Object.prototype),i.Mesh.prototype.update=function(t,e){var r,n,s,o,a;if(this.geometry.update(),e)for(r=this.geometry.triangles.length-1;r>=0;r--){for(n=this.geometry.triangles[r],i.Vector4.set(n.color.rgba),s=t.length-1;s>=0;s--)o=t[s],i.Vector3.subtractVectors(o.ray,o.position,n.centroid),i.Vector3.normalise(o.ray),a=i.Vector3.dot(n.normal,o.ray),this.side===i.FRONT?a=Math.max(a,0):this.side===i.BACK?a=Math.abs(Math.min(a,0)):this.side===i.DOUBLE&&(a=Math.max(Math.abs(a),0)),i.Vector4.multiplyVectors(this.material.slave.rgba,this.material.ambient.rgba,o.ambient.rgba),i.Vector4.add(n.color.rgba,this.material.slave.rgba),i.Vector4.multiplyVectors(this.material.slave.rgba,this.material.diffuse.rgba,o.diffuse.rgba),i.Vector4.multiplyScalar(this.material.slave.rgba,a),i.Vector4.add(n.color.rgba,this.material.slave.rgba);i.Vector4.clamp(n.color.rgba,0,1)}return this},i.Scene=function(){this.meshes=[],this.lights=[]},i.Scene.prototype={add:function(t){return t instanceof i.Mesh&&!~this.meshes.indexOf(t)?this.meshes.push(t):t instanceof i.Light&&!~this.lights.indexOf(t)&&this.lights.push(t),this},remove:function(t){return t instanceof i.Mesh&&~this.meshes.indexOf(t)?this.meshes.splice(this.meshes.indexOf(t),1):t instanceof i.Light&&~this.lights.indexOf(t)&&this.lights.splice(this.lights.indexOf(t),1),this}},i.Renderer=function(){this.halfHeight=this.halfWidth=this.height=this.width=0},i.Renderer.prototype={setSize:function(t,e){return this.width!==t||this.height!==e?(this.width=t,this.height=e,this.halfWidth=.5*this.width,this.halfHeight=.5*this.height,this):void 0},clear:function(){return this},render:function(){return this}},i.CanvasRenderer=function(){i.Renderer.call(this),this.element=document.createElement("canvas"),this.element.style.display="block",this.context=this.element.getContext("2d"),this.setSize(this.element.width,this.element.height)},i.CanvasRenderer.prototype=Object.create(i.Renderer.prototype),i.CanvasRenderer.prototype.setSize=function(t,e){return i.Renderer.prototype.setSize.call(this,t,e),this.element.width=t,this.element.height=e,this.context.setTransform(1,0,0,-1,this.halfWidth,this.halfHeight),this},i.CanvasRenderer.prototype.clear=function(){return i.Renderer.prototype.clear.call(this),this.context.clearRect(-this.halfWidth,-this.halfHeight,this.width,this.height),this},i.CanvasRenderer.prototype.render=function(t){i.Renderer.prototype.render.call(this,t);var e,r,n,s,o;for(this.clear(),this.context.lineJoin="round",this.context.lineWidth=1,e=t.meshes.length-1;e>=0;e--)if(r=t.meshes[e],r.visible)for(r.update(t.lights,!0),n=r.geometry.triangles.length-1;n>=0;n--)s=r.geometry.triangles[n],o=s.color.format(),this.context.beginPath(),this.context.moveTo(s.a.position[0],s.a.position[1]),this.context.lineTo(s.b.position[0],s.b.position[1]),this.context.lineTo(s.c.position[0],s.c.position[1]),this.context.closePath(),this.context.strokeStyle=o,this.context.fillStyle=o,this.context.stroke(),this.context.fill();return this},i.WebGLRenderer=function(){return i.Renderer.call(this),this.element=document.createElement("canvas"),this.element.style.display="block",this.lights=this.vertices=null,this.gl=this.getContext(this.element,{preserveDrawingBuffer:!1,premultipliedAlpha:!0,antialias:!0,stencil:!0,alpha:!0}),(this.unsupported=!this.gl)?"WebGL is not supported by your browser.":(this.gl.clearColor(0,0,0,0),this.gl.enable(this.gl.DEPTH_TEST),void this.setSize(this.element.width,this.element.height))},i.WebGLRenderer.prototype=Object.create(i.Renderer.prototype),i.WebGLRenderer.prototype.getContext=function(t,e){var i=!1;try{if(!(i=t.getContext("experimental-webgl",e)))throw"Error creating WebGL context."}catch(r){}return i},i.WebGLRenderer.prototype.setSize=function(t,e){return i.Renderer.prototype.setSize.call(this,t,e),this.unsupported?void 0:(this.element.width=t,this.element.height=e,this.gl.viewport(0,0,t,e),this)},i.WebGLRenderer.prototype.clear=function(){return i.Renderer.prototype.clear.call(this),this.unsupported?void 0:(this.gl.clear(this.gl.COLOR_BUFFER_BIT|this.gl.DEPTH_BUFFER_BIT),this)},i.WebGLRenderer.prototype.render=function(t){if(i.Renderer.prototype.render.call(this,t),!this.unsupported){var e,r,n,s,o,a,h,l;a=!1;var c,u,f,d=t.lights.length,m=0;if(this.clear(),this.lights!==d){if(this.lights=d,!(0<this.lights))return;this.buildProgram(d)}if(this.program){for(e=t.meshes.length-1;e>=0;e--)r=t.meshes[e],r.geometry.dirty&&(a=!0),r.update(t.lights,!1),m+=3*r.geometry.triangles.length;if(a||this.vertices!==m)for(h in this.vertices=m,this.program.attributes){for(a=this.program.attributes[h],a.data=new i.Array(m*a.size),c=0,e=t.meshes.length-1;e>=0;e--)for(r=t.meshes[e],n=0,s=r.geometry.triangles.length;s>n;n++)for(o=r.geometry.triangles[n],u=0,f=o.vertices.length;f>u;u++){switch(vertex=o.vertices[u],h){case"side":this.setBufferData(c,a,r.side);break;case"position":this.setBufferData(c,a,vertex.position);break;case"centroid":this.setBufferData(c,a,o.centroid);break;case"normal":this.setBufferData(c,a,o.normal);break;case"ambient":this.setBufferData(c,a,r.material.ambient.rgba);break;case"diffuse":this.setBufferData(c,a,r.material.diffuse.rgba)}c++}this.gl.bindBuffer(this.gl.ARRAY_BUFFER,a.buffer),this.gl.bufferData(this.gl.ARRAY_BUFFER,a.data,this.gl.DYNAMIC_DRAW),this.gl.enableVertexAttribArray(a.location),this.gl.vertexAttribPointer(a.location,a.size,this.gl.FLOAT,!1,0,0)}for(this.setBufferData(0,this.program.uniforms.resolution,[this.width,this.height,this.width]),a=d-1;a>=0;a--)e=t.lights[a],this.setBufferData(a,this.program.uniforms.lightPosition,e.position),this.setBufferData(a,this.program.uniforms.lightAmbient,e.ambient.rgba),this.setBufferData(a,this.program.uniforms.lightDiffuse,e.diffuse.rgba);for(l in this.program.uniforms)switch(a=this.program.uniforms[l],e=a.location,t=a.data,a.structure){case"3f":this.gl.uniform3f(e,t[0],t[1],t[2]);break;case"3fv":this.gl.uniform3fv(e,t);break;case"4fv":this.gl.uniform4fv(e,t)}}return this.gl.drawArrays(this.gl.TRIANGLES,0,this.vertices),this}},i.WebGLRenderer.prototype.setBufferData=function(t,e,r){if(i.Utils.isNumber(r))e.data[t*e.size]=r;else for(var n=r.length-1;n>=0;n--)e.data[t*e.size+n]=r[n]},i.WebGLRenderer.prototype.buildProgram=function(t){if(!this.unsupported){var e=i.WebGLRenderer.VS(t),r=i.WebGLRenderer.FS(t),n=e+r;if(!this.program||this.program.code!==n){var s=this.gl.createProgram(),e=this.buildShader(this.gl.VERTEX_SHADER,e),r=this.buildShader(this.gl.FRAGMENT_SHADER,r);return this.gl.attachShader(s,e),this.gl.attachShader(s,r),this.gl.linkProgram(s),this.gl.getProgramParameter(s,this.gl.LINK_STATUS)?(this.gl.deleteShader(r),this.gl.deleteShader(e),s.code=n,s.attributes={side:this.buildBuffer(s,"attribute","aSide",1,"f"),position:this.buildBuffer(s,"attribute","aPosition",3,"v3"),centroid:this.buildBuffer(s,"attribute","aCentroid",3,"v3"),normal:this.buildBuffer(s,"attribute","aNormal",3,"v3"),ambient:this.buildBuffer(s,"attribute","aAmbient",4,"v4"),diffuse:this.buildBuffer(s,"attribute","aDiffuse",4,"v4")},s.uniforms={resolution:this.buildBuffer(s,"uniform","uResolution",3,"3f",1),lightPosition:this.buildBuffer(s,"uniform","uLightPosition",3,"3fv",t),lightAmbient:this.buildBuffer(s,"uniform","uLightAmbient",4,"4fv",t),lightDiffuse:this.buildBuffer(s,"uniform","uLightDiffuse",4,"4fv",t)},this.program=s,this.gl.useProgram(this.program),s):(t=this.gl.getError(),s=this.gl.getProgramParameter(s,this.gl.VALIDATE_STATUS),console.error("Could not initialise shader.\nVALIDATE_STATUS: "+s+"\nERROR: "+t),null)}}},i.WebGLRenderer.prototype.buildShader=function(t,e){if(!this.unsupported){var i=this.gl.createShader(t);return this.gl.shaderSource(i,e),this.gl.compileShader(i),this.gl.getShaderParameter(i,this.gl.COMPILE_STATUS)?i:(console.error(this.gl.getShaderInfoLog(i)),null)}},i.WebGLRenderer.prototype.buildBuffer=function(t,e,r,n,s,o){switch(s={buffer:this.gl.createBuffer(),size:n,structure:s,data:null},e){case"attribute":s.location=this.gl.getAttribLocation(t,r);break;case"uniform":s.location=this.gl.getUniformLocation(t,r)}return o&&(s.data=new i.Array(o*n)),s},i.WebGLRenderer.VS=function(t){return["precision mediump float;","#define LIGHTS "+t,"attribute float aSide;\nattribute vec3 aPosition;\nattribute vec3 aCentroid;\nattribute vec3 aNormal;\nattribute vec4 aAmbient;\nattribute vec4 aDiffuse;\nuniform vec3 uResolution;\nuniform vec3 uLightPosition[LIGHTS];\nuniform vec4 uLightAmbient[LIGHTS];\nuniform vec4 uLightDiffuse[LIGHTS];\nvarying vec4 vColor;\nvoid main() {\nvColor = vec4(0.0);\nvec3 position = aPosition / uResolution * 2.0;\nfor (int i = 0; i < LIGHTS; i++) {\nvec3 lightPosition = uLightPosition[i];\nvec4 lightAmbient = uLightAmbient[i];\nvec4 lightDiffuse = uLightDiffuse[i];\nvec3 ray = normalize(lightPosition - aCentroid);\nfloat illuminance = dot(aNormal, ray);\nif (aSide == 0.0) {\nilluminance = max(illuminance, 0.0);\n} else if (aSide == 1.0) {\nilluminance = abs(min(illuminance, 0.0));\n} else if (aSide == 2.0) {\nilluminance = max(abs(illuminance), 0.0);\n}\nvColor += aAmbient * lightAmbient;\nvColor += aDiffuse * lightDiffuse * illuminance;\n}\nvColor = clamp(vColor, 0.0, 1.0);\ngl_Position = vec4(position, 1.0);\n}"].join("\n")},i.WebGLRenderer.FS=function(){return"precision mediump float;\nvarying vec4 vColor;\nvoid main() {\ngl_FragColor = vColor;\n}"},i.SVGRenderer=function(){i.Renderer.call(this),this.element=document.createElementNS(i.SVGNS,"svg"),this.element.setAttribute("xmlns",i.SVGNS),this.element.setAttribute("version","1.1"),this.element.style.display="block",this.setSize(300,150)},i.SVGRenderer.prototype=Object.create(i.Renderer.prototype),i.SVGRenderer.prototype.setSize=function(t,e){return i.Renderer.prototype.setSize.call(this,t,e),this.element.setAttribute("width",t),this.element.setAttribute("height",e),this},i.SVGRenderer.prototype.clear=function(){i.Renderer.prototype.clear.call(this);for(var t=this.element.childNodes.length-1;t>=0;t--)this.element.removeChild(this.element.childNodes[t]);return this},i.SVGRenderer.prototype.render=function(t){i.Renderer.prototype.render.call(this,t);var e,r,n,s,o,a;for(e=t.meshes.length-1;e>=0;e--)if(r=t.meshes[e],r.visible)for(r.update(t.lights,!0),n=r.geometry.triangles.length-1;n>=0;n--)s=r.geometry.triangles[n],s.polygon.parentNode!==this.element&&this.element.appendChild(s.polygon),o=this.formatPoint(s.a)+" ",o+=this.formatPoint(s.b)+" ",o+=this.formatPoint(s.c),a=this.formatStyle(s.color.format()),s.polygon.setAttributeNS(null,"points",o),s.polygon.setAttributeNS(null,"style",a);return this},i.SVGRenderer.prototype.formatPoint=function(t){return this.halfWidth+t.position[0]+","+(this.halfHeight-t.position[1])},i.SVGRenderer.prototype.formatStyle=function(t){return t="fill:"+t+";"+("stroke:"+t+";")},/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)||function(){function r(){v.remove(S),y.clear(),V=new i.Plane(h.width*y.width,h.height*y.height,h.segments,h.slices),w=new i.Material(h.ambient,h.diffuse),S=new i.Mesh(V,w),v.add(S);var t,e;for(t=V.vertices.length-1;t>=0;t--)e=V.vertices[t],e.anchor=i.Vector3.clone(e.position),e.step=i.Vector3.create(Math.randomInRange(.2,1),Math.randomInRange(.2,1),Math.randomInRange(.2,1)),e.time=Math.randomInRange(0,Math.PIM2)}function n(t,e){y.setSize(t,e),i.Vector3.set(m,y.halfWidth,y.halfHeight),r()}function s(){a=Date.now()-d;var t,e,r,n,c,u=h.depth/2;for(i.Vector3.copy(l.bounds,m),i.Vector3.multiplyScalar(l.bounds,l.xyScalar),i.Vector3.setZ(g,l.zOffset),l.autopilot&&(t=Math.sin(l.step[0]*a*l.speed),e=Math.cos(l.step[1]*a*l.speed),i.Vector3.set(g,l.bounds[0]*t,l.bounds[1]*e,l.zOffset)),t=v.lights.length-1;t>=0;t--)e=v.lights[t],i.Vector3.setZ(e.position,l.zOffset),r=Math.clamp(i.Vector3.distanceSquared(e.position,g),l.minDistance,l.maxDistance),r=l.gravity*e.mass/r,i.Vector3.subtractVectors(e.force,g,e.position),i.Vector3.normalise(e.force),i.Vector3.multiplyScalar(e.force,r),i.Vector3.set(e.acceleration),i.Vector3.add(e.acceleration,e.force),i.Vector3.add(e.velocity,e.acceleration),i.Vector3.multiplyScalar(e.velocity,l.dampening),i.Vector3.limit(e.velocity,l.minLimit,l.maxLimit),i.Vector3.add(e.position,e.velocity);for(n=V.vertices.length-1;n>=0;n--)c=V.vertices[n],t=Math.sin(c.time+c.step[0]*a*h.speed),e=Math.cos(c.time+c.step[1]*a*h.speed),r=Math.sin(c.time+c.step[2]*a*h.speed),i.Vector3.set(c.position,h.xRange*V.segmentWidth*t,h.yRange*V.sliceHeight*e,h.zRange*u*r-u),i.Vector3.add(c.position,c.anchor);V.dirty=!0,o(),requestAnimationFrame(s)}function o(){if(y.render(v),l.draw){var t,e,i,r;for(t=v.lights.length-1;t>=0;t--)switch(r=v.lights[t],e=r.position[0],i=r.position[1],f.renderer){case c:y.context.lineWidth=.5,y.context.beginPath(),y.context.arc(e,i,10,0,Math.PIM2),y.context.strokeStyle=r.ambientHex,y.context.stroke(),y.context.beginPath(),y.context.arc(e,i,4,0,Math.PIM2),y.context.fillStyle=r.diffuseHex,y.context.fill();break;case u:e+=y.halfWidth,i=y.halfHeight-i,r.core.setAttributeNS(null,"fill",r.diffuseHex),r.core.setAttributeNS(null,"cx",e),r.core.setAttributeNS(null,"cy",i),y.element.appendChild(r.core),r.ring.setAttributeNS(null,"stroke",r.ambientHex),r.ring.setAttributeNS(null,"cx",e),r.ring.setAttributeNS(null,"cy",i),y.element.appendChild(r.ring)}}}var a,h={width:1.8,height:1.8,depth:10,segments:16,slices:8,xRange:.8,yRange:.1,zRange:1,ambient:"#010101",diffuse:"#ffffff",speed:6e-4,opacity:.5},l={count:2,xyScalar:1,zOffset:100,ambient:"#ffffff",diffuse:"#2d2d2d",speed:.001,gravity:800,dampening:.95,minLimit:10,maxLimit:null,minDistance:20,maxDistance:400,autopilot:!1,draw:!1,bounds:i.Vector3.create(),step:i.Vector3.create(Math.randomInRange(.2,1),Math.randomInRange(.2,1),Math.randomInRange(.2,1))},c="canvas",u="svg",f={renderer:c},d=Date.now(),m=i.Vector3.create(),g=i.Vector3.create(),p=document.getElementById(t||"container");document.getElementById("controls");var b=document.getElementById(e||"output");document.getElementById("ui");var y,v,S,V,w,R,x,A;R=new i.WebGLRenderer,x=new i.CanvasRenderer,A=new i.SVGRenderer,function(t){switch(y&&b.removeChild(y.element),t){case"webgl":y=R;break;case c:y=x;break;case u:y=A}y.setSize(p.offsetWidth,p.offsetHeight),b.appendChild(y.element)}(f.renderer),v=new i.Scene,r(),function(){var t,e;for(t=v.lights.length-1;t>=0;t--)e=v.lights[t],v.remove(e);for(y.clear(),t=0;t<l.count;t++)e=new i.Light(l.ambient,l.diffuse),e.ambientHex=e.ambient.format(),e.diffuseHex=e.diffuse.format(),v.add(e),e.mass=Math.randomInRange(.5,1),e.velocity=i.Vector3.create(),e.acceleration=i.Vector3.create(),e.force=i.Vector3.create(),e.ring=document.createElementNS(i.SVGNS,"circle"),e.ring.setAttributeNS(null,"stroke",e.ambientHex),e.ring.setAttributeNS(null,"stroke-width","0.5"),e.ring.setAttributeNS(null,"fill","none"),e.ring.setAttributeNS(null,"r","10"),e.core=document.createElementNS(i.SVGNS,"circle"),e.core.setAttributeNS(null,"fill",e.diffuseHex),e.core.setAttributeNS(null,"r","4")}(),window.addEventListener("resize",function(){n(p.offsetWidth,p.offsetHeight),o()}),p.addEventListener("click",function(t){i.Vector3.set(g,t.x,y.height-t.y),i.Vector3.subtract(g,m),l.autopilot=!l.autopilot,void 0.updateDisplay()}),p.addEventListener("mousemove",function(t){i.Vector3.set(g,t.x,y.height-t.y),i.Vector3.subtract(g,m)}),n(p.offsetWidth,p.offsetHeight),s()}()};e.cbd=i});