import Plugin from '@ckeditor/ckeditor5-core/src/plugin';
import ButtonView from '@ckeditor/ckeditor5-ui/src/button/buttonview';
import ModelElement from '@ckeditor/ckeditor5-engine/src/model/element';
import videoIcon from './../icon/multimedia.svg';

export default class VideoPlugin extends Plugin {
    init() {
        const editor = this.editor;

        editor.ui.componentFactory.add( 'videoPlugin', locale => {
            const view = new ButtonView( locale );

            view.set( {
                label: 'Insert video',
                icon: videoIcon,
                tooltip: true
            } );

            view.on( 'execute', () => {
              alert('vidéo');
            } );

            return view;
        } );
    }
}
