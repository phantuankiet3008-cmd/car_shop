import * as THREE from "three";
import { OrbitControls } from "three/addons/controls/OrbitControls.js";
import { GLTFLoader } from "three/addons/loaders/GLTFLoader.js";

const btn3D = document.getElementById("btn3D");
const viewer = document.getElementById("mo_hinh_3D");
const container = document.getElementById("threeContainer");
const closeBtn = document.querySelector(".close3d");

let renderer, scene, camera, controls;
let isInitialized = false;

btn3D.addEventListener("click", () => {
    viewer.classList.remove("hidden");

    // Chờ layout thực sự có kích thước rồi mới init
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            if (!isInitialized) {
                initThreeJS();
                isInitialized = true;
            } else {
                resizeRenderer();
            }
        });
    });
});

closeBtn.addEventListener("click", () => {
    viewer.classList.add("hidden");
});

function initThreeJS() {
    const modelPath = btn3D.getAttribute("data-model");

    scene = new THREE.Scene();
    scene.background = new THREE.Color(0x0a0a0a);

    const w = container.clientWidth;
    const h = container.clientHeight;

    camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 1000);
    camera.position.set(6, 4, 6);

    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setPixelRatio(window.devicePixelRatio);
    renderer.setSize(w, h);
    container.appendChild(renderer.domElement);

    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Ánh sáng
    scene.add(new THREE.AmbientLight(0xffffff, 1.5));
    const light = new THREE.DirectionalLight(0xffffff, 2);
    light.position.set(5, 10, 7);
    scene.add(light);

    const loader = new GLTFLoader();
    loader.load(modelPath, (gltf) => {
        const model = gltf.scene;

        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());
        const size = box.getSize(new THREE.Vector3()).length();

        model.position.sub(center);
        model.scale.setScalar(5 / size);

        scene.add(model);
    });

    window.addEventListener("resize", resizeRenderer);

    animate();
}

function resizeRenderer() {
    if (!renderer) return;

    const w = container.clientWidth;
    const h = container.clientHeight;

    if (w === 0 || h === 0) return;

    camera.aspect = w / h;
    camera.updateProjectionMatrix();
    renderer.setSize(w, h);
}

function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}
