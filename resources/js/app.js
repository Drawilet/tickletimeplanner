import "./bootstrap";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import intersect from "@alpinejs/intersect";

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(intersect);

Alpine.start();
