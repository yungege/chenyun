define("common:widget/view/parseobj.js",function(e,n){var t=e("common:widget/lib/three.js"),r={parse:function(e){for(var n=/v( +[\d|\.|\+|\-|e|E]+)( +[\d|\.|\+|\-|e|E]+)( +[\d|\.|\+|\-|e|E]+)/,r=/f( +-?\d+)( +-?\d+)( +-?\d+)( +-?\d+)?/,d=/f( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+))?/,s=/f( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))( +(-?\d+)\/(-?\d+)\/(-?\d+))?/,o=/f( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))( +(-?\d+)\/\/(-?\d+))?/,a=e.split("\n"),p=[],l=[],c=0;c<a.length;c++){var u=a[c],h=null;u=u.trim(),0!==u.length&&"#"!==u.charAt(0)&&(null!==(h=n.exec(u))?p.push([parseFloat(h[1]),parseFloat(h[2]),parseFloat(h[3])]):null!==(h=r.exec(u))?l.push([parseInt(h[1]),parseInt(h[2]),parseInt(h[3])]):null!==(h=d.exec(u))?l.push([parseInt(h[2]),parseInt(h[5]),parseInt(h[8])]):null!==(h=s.exec(u))?l.push([parseInt(h[2]),parseInt(h[6]),parseInt(h[10])]):null!==(h=o.exec(u))&&console.log(h))}for(var i=new t.THREE.Geometry,c=0;c<l.length;c++){var E,g,v=p[l[c][0]-1],f=p[l[c][1]-1],w=p[l[c][2]-1];try{var I=[v[0],v[1],v[2]],m=[f[0],f[1],f[2]],x=[w[0],w[1],w[2]]}catch(H){console.log(l[c],v,f,w);continue}var R=function(){var e,n,t,r,d,s,o=[],a=0,p=0,l=0;return e=m[0]-I[0],n=m[1]-I[1],t=m[2]-I[2],r=x[0]-I[0],d=x[1]-I[1],s=x[2]-I[2],a=s*n-d*t,p=e*s-r*t,l=e*d-r*n,o.push(a),o.push(p),o.push(l),o};E=R(),g=new t.THREE.Vector3(E[0],E[1],E[2]),i.vertices.push(new t.THREE.Vector3(I[0],I[1],I[2])),i.vertices.push(new t.THREE.Vector3(m[0],m[1],m[2])),i.vertices.push(new t.THREE.Vector3(x[0],x[1],x[2])),length=i.vertices.length,i.faces.push(new t.THREE.Face3(length-3,length-2,length-1,g))}return i.computeBoundingBox(),i.computeBoundingSphere(),i}};n.parseobj=r});