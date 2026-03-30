import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

let scene, camera, renderer, controls;
const container = document.getElementById('threeContainer');

document.addEventListener("DOMContentLoaded", function () {
    const btn3D = document.getElementById('btn3D');
    const close3d = document.querySelector('.close3d');
    const moHinh3D = document.getElementById('mo_hinh_3D');
    const vungAnhXe = document.getElementById('vung_anh_xe');

    if (btn3D) {
        btn3D.addEventListener('click', function () {
            moHinh3D.classList.remove('hidden');
            vungAnhXe.style.display = 'none'; // Ẩn hẳn để nhường chỗ cho 3D
            btn3D.style.display = 'none';
            
            if (!renderer) {
                initThreeJS(btn3D.getAttribute("data-model"));
            }
        });
    }

    if (close3d) {
        close3d.addEventListener('click', function () {
            moHinh3D.classList.add('hidden');
            vungAnhXe.style.display = 'flex'; // Hiện lại ảnh lớn
            if(btn3D) btn3D.style.display = 'block';
        });
    }
});

function initThreeJS(modelPath) {
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xf1f5f9); // Màu nền xám nhạt cho sang

    const w = container.clientWidth;
    const h = container.clientHeight;

    camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 1000);
    camera.position.set(8, 4, 8);


    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(w, h);
    renderer.toneMapping = THREE.ReinhardToneMapping; // Giúp màu sắc chân thực hơn
    container.appendChild(renderer.domElement);

    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Ánh sáng cực kỳ quan trọng để không bị đen
    scene.add(new THREE.AmbientLight(0xffffff, 2)); // Tăng cường độ sáng môi trường
    
    const light1 = new THREE.DirectionalLight(0xffffff, 3);
    light1.position.set(5, 10, 7);
    scene.add(light1);

    const light2 = new THREE.DirectionalLight(0xffffff, 2);
    light2.position.set(-5, 5, -7);
    scene.add(light2);

    const loader = new GLTFLoader();
    loader.load(modelPath, (gltf) => {
        const model = gltf.scene;
        
        // Căn giữa model tự động
        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3()).length();
        
        model.position.sub(center);
        model.scale.setScalar(8 / size); // Điều chỉnh kích thước hiển thị

        scene.add(model);
    }, undefined, (error) => {
        console.error("Lỗi load file 3D:", error);
    });

    window.addEventListener("resize", onWindowResize);
    animate();
}

function onWindowResize() {
    const w = container.clientWidth;
    const h = container.clientHeight;
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
}

function animate() {
    requestAnimationFrame(animate);
    if (controls) controls.update();
    if (renderer) renderer.render(scene, camera);
}
