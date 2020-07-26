var timeoutInput;

document.addEventListener("DOMContentLoaded", function () {

    draw(preSelected);
});

function draw(preSelected){
    console.log(preSelected);
    let parent = document.getElementById(preSelected.multiselection);

    let label = document.createElement('label');
    let select = document.createElement('select');
    let span = document.createElement('span');
    let input = document.createElement('input');
    let datalist = document.createElement('datalist');

    select.multiple = true;
    select.name = preSelected.submitName;
    select.id = preSelected.submitName;
    select.classList.add('none');
    
    label.innerHTML = preSelected.label;
    
    span.id = preSelected.label + 'SPAN';
    span.classList.add('seleccionados');

    input.id = preSelected.label + 'SELECTED';
    input.name = preSelected.label + 'SELECTED';
    input.setAttribute('list', preSelected.label + 'DATALIST');
    input.placeholder = preSelected.label;
    input.type = 'text';
    input.addEventListener('input', onInput(preSelected.submitName, preSelected.label + 'SPAN') );
    input.classList.add('input');
    input.classList.add('size-4');

    datalist.id = preSelected.label + 'DATALIST';
    preSelected.all.forEach( p => {
        let option = document.createElement('option');
        option.value = p.id;
        option.setAttribute('data-value', JSON.stringify(p)),
        option.innerHTML = p.display_name;
        datalist.appendChild(option);
    });

    let arr = preSelected.all.filter( a => {
        return preSelected.selecteds.some(e => e == a.id);
    });
    
    appendPreselected(arr, select, span);


    parent.appendChild(label);
    parent.appendChild(select);
    parent.appendChild(span);
    parent.appendChild(input);
    parent.appendChild(datalist);
}

function appendPreselected(arr, to, displayIn) {

    arr.forEach(obj => {
        if(obj){
            append(obj, to, displayIn);
        }
    });
}

function append(obj, to, displayIn){

    let div = document.createElement('div');
    div.setAttribute('data-descr', obj.display_name);
    div.classList.add('div-selected');
    displayIn.appendChild(div);
    let opt = document.createElement('option');
    opt.value = obj.id;
    opt.selected = true;
    to.appendChild(opt);
    div.addEventListener('click', onUnselect(displayIn, div, to, opt));
}

function isInput(type){
    return type && ( type == 'insertText' || type == 'deleteContentBackward');
}

function onInput(to, displayIn){

    return (e) => {
        let type = e.inputType;
        if(!isInput(type)){
            clearTimeout(timeoutInput);
            timeoutInput = setTimeout( () => {
                e.preventDefault();
                let selected = e.target.value;
                let collection = e.target.list.children;
                let arr = Array.prototype.slice.call( collection );
                let obj = arr.find( a => {
                    let val = JSON.parse(a.getAttribute('data-value'));
                    return val.id == selected;
                });
                if(obj){
                    obj =  JSON.parse(obj.getAttribute('data-value'));
                    let toDisplay = document.getElementById(displayIn);
                    let select = document.getElementById(to);
                    collection = select.children;
                    arr = Array.prototype.slice.call(collection);
                    let exist = arr.find( a => {
                        return a.value == obj.id;
                    });
                    if(!exist){
                        e.target.value = '';
                        append(obj, select, toDisplay);
                    }
                }
            }, 200);
        }
    }
}

function onUnselect(target1, child1, target2, child2){
    return () => {
        target1.removeChild(child1);
        target2.removeChild(child2);
    };
}
