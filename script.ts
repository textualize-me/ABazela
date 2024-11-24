const msg: string = "Hello!";
alert(msg);

const styles: Record<string, string> = {
    'version 1': 'styles/style.css',
    'version 2': 'styles/style2.css',
    'version 3': 'styles/style3.css'
};

const setStyle = (styleName: string) => {
    const link = document.querySelector('link[rel="stylesheet"]');
    if (link) link.remove();

    const styleLink = document.createElement('link');
    styleLink.rel = 'stylesheet';
    styleLink.href = styles[styleName];
    document.head.appendChild(styleLink);
};

document.addEventListener('DOMContentLoaded', () => {
    setStyle('version 1');

    const buttonContainer = document.createElement('div');

    Object.keys(styles).forEach(styleName => {
        const button = document.createElement('button');
        button.textContent = `${styleName}`;
        button.onclick = () => setStyle(styleName);
        buttonContainer.appendChild(button);
    });

    document.body.appendChild(buttonContainer);
});
