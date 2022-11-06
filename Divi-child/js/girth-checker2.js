//For each input [weight, height, length, width] validate:
////weight must not be greater than 70
////max dimenision must not exceed 108 inches
////sum of other dimensions x2 must not exceed 165
////// var girth=""

console.log("GirthChecker version 11.23 called.");

let getWeight = document.getElementById("_weight");
let getLength = document.getElementById("_length");
let getWidth = document.getElementById("_width");
let getHeight = document.getElementById("_height");

const weightWarning = document.getElementById("mbatt-warning_weight");
const girthWarning = document.getElementById("mbatt-warning_girth");
const lengthWarning = document.getElementById("mbatt-warning_length");
const widthWarning = document.getElementById("mbatt-warning_width");
const heightWarning = document.getElementById("mbatt-warning_height");

// var valWeight = Number(getWeight.value);
// let valLength = Number(getLength.value);
// let valWidth = Number(getWidth.value);
// let valHeight = Number(getHeight.value);

// console.log(`The weight is ${valWeight}`);
// console.log(`The length is ${valLength}`);
// console.log(`The width is ${valWidth}`);
// console.log(`The height is ${valHeight}`);

getWeight.addEventListener("change", (event) => {
  let valWeight = Number(getWeight.value);
  console.log(valWeight);
  if (valWeight > Number(70)) {
    console.log(
      `This package is too heavy for regular shipping. Please select crate shipping. Need help?`
    );
    weightWarning.classList.remove("mbatt-hidden");
  } else {
    weightWarning.classList.add("mbatt-hidden");
  }
});

function fNotice(girth) {
  console.log(
    `This package has a girth of ${girth}in, too large for regular shipping. Please select crate shipping. Need help?`
  );
  girthWarning.classList.remove("mbatt-hidden");
}

function checkGirth() {
  let fL = Number(getLength.value);
  let fW = Number(getWidth.value);
  let fH = Number(getHeight.value);
  let lGirth = Number(fL + 2 * fW + 2 * fH);
  let wGirth = Number(fW + 2 * fL + 2 * fH);
  let hGirth = Number(fH + 2 * fW + 2 * fL);
  //if L is greater than W and greater than H, or if L is equal to H and greater than W, or if L is equal to H and greater than W.
  if (
    (fL > fW && fL > fH) ||
    (fL === fW && fL > fH) ||
    (fL === fH && fL > fW)
  ) {
    //check fL + 2fW + 2fH
    if (lGirth > 165) {
      console.log(
        `👋 GIRTH ERROR \n Length is the greatest dimension. \n L=${fL} W=${fW} H=${fH} \n ${fL}+${fW}+${fW}+${fH}+${fH} = ${lGirth}. \n Max is 165.`
      );
      fNotice(lGirth);
      return;
    } else {
      girthWarning.classList.add("mbatt-hidden");
    }
  }
  //is H greater than W and L? or is H equal to W, and greater than L?
  if ((fH > fW && fH > fL) || (fH === fW && fH > fL)) {
    //check fH + 2fW + 2fL
    if (hGirth > 165) {
      console.log(
        `👋 GIRTH ERROR \n Height is the greatest dimension. \n L=${fL} W=${fW} H=${fH} \n ${fL}+${fL}+${fW}+${fW}+${fH} = ${lGirth}. \n Max is 165.`
      );
      fNotice(hGirth);
      return;
    } else {
      girthWarning.classList.add("mbatt-hidden");
    }
  }

  //is L greater than W and H?
  if (fW > fL && fW > fH) {
    //check fW + 2fL + 2fH
    if (wGirth > 165) {
      console.log(
        `👋 GIRTH ERROR \n Width is the greatest dimension. \n L=${fL} W=${fW} H=${fH} \n ${fL}+${fL}+${fW}+${fH}+${fH} = ${wGirth}. \n Max is 165.`
      );
      fNotice(wGirth);
      return;
    } else {
      girthWarning.classList.add("mbatt-hidden");
    }
  }

  if (fL === fW && fW === fH && fL + 2 * fW + 2 * fH > 165) {
    console.log(
      `👋 GIRTH ERROR \n That's a big cube! \n L=${fL} W=${fW} H=${fH} \n ${fL}+${fL}+${fW}+${fH}+${fH} = ${wGirth}. \n Max is 165.`
    );
    fNotice(wGirth);
    return;
  } else {
    girthWarning.classList.add("mbatt-hidden");
  }
  console.log("Regular shipping should be OK.");
}

getLength.addEventListener("change", (event) => {
  let valLength = Number(getLength.value);
  console.log(`Length set to: ${valLength}in.`);
  checkGirth();
  if (valLength > Number(108)) {
    console.log(
      "This package's length exceeds 108in, and is too long for regular shipping. Please select crate shipping. Need help?"
    );
    lengthWarning.classList.remove("mbatt-hidden");
  } else {
    lengthWarning.classList.add("mbatt-hidden");
  }
});

getWidth.addEventListener("change", (event) => {
  let valWidth = Number(getWidth.value);
  console.log(`Width set to: ${valWidth}in.`);
  checkGirth();
  if (valWidth > Number(108)) {
    console.log(
      "This package's width exceeds 108in, and is too wide for regular shipping. Please select crate shipping. Need help?"
    );
    widthWarning.classList.remove("mbatt-hidden");
  } else {
    widthWarning.classList.add("mbatt-hidden");
  }
});

getHeight.addEventListener("change", (event) => {
  let valHeight = Number(getHeight.value);
  console.log(`Height set to: ${valHeight}in.`);
  checkGirth();
  if (valHeight > Number(108)) {
    console.log(
      "This package's height exceeds 108in, and is too tall for regular shipping. Please select crate shipping. Need help?"
    );
    heightWarning.classList.remove("mbatt-hidden");
  } else {
    heightWarning.classList.add("mbatt-hidden");
  }
});
