import 'dart:io';
import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';

class ModifierLivreScreen extends StatefulWidget {
  final Map livre; // Data li jaya mn l-page dyal l-list

  const ModifierLivreScreen({super.key, required this.livre});

  @override
  State<ModifierLivreScreen> createState() => _ModifierLivreScreenState();
}

class _ModifierLivreScreenState extends State<ModifierLivreScreen> {
  final _formKey = GlobalKey<FormState>();
  
  // Controllers m-chargyin b data l-9dima
  late TextEditingController _titreController;
  late TextEditingController _descController;
  String? _selectedAgeRange;
  File? _newImageFile;
  bool _isLoading = false;

  @override
  void initState() {
    super.initState();
    // Initialisation dyal l-fields b l-9dim
    _titreController = TextEditingController(text: widget.livre['titre']);
    _descController = TextEditingController(text: widget.livre['description']);
    _selectedAgeRange = "${widget.livre['age_min']}-${widget.livre['age_max']}";
  }

  Future<void> _pickImage() async {
    final picker = ImagePicker();
    final picked = await picker.pickImage(source: ImageSource.gallery);
    if (picked != null) setState(() => _newImageFile = File(picked.path));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF9FAFB),
      appBar: AppBar(
        title: RichText(
          text: TextSpan(
            text: "Modifier le livre : ",
            style: const TextStyle(color: Colors.black87, fontSize: 18),
            children: [
              TextSpan(
                text: widget.livre['titre'],
                style: const TextStyle(color: Color(0xFFD97706), fontWeight: FontWeight.bold),
              ),
            ],
          ),
        ),
        backgroundColor: Colors.white,
        elevation: 0.5,
        iconTheme: const IconThemeData(color: Colors.black87),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 24),
        child: Form(
          key: _formKey,
          child: Column(
            children: [
              Container(
                decoration: BoxDecoration(
                  color: Colors.white,
                  borderRadius: BorderRadius.circular(12),
                  // Border Amber l-foqani b7al Laravel
                  border: const Border(top: BorderSide(color: Color(0xFFF59E0B), width: 4)),
                  boxShadow: [BoxShadow(color: Colors.black.withOpacity(0.05), blurRadius: 10)],
                ),
                padding: const EdgeInsets.all(20),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _label("Titre"),
                    _textField(_titreController, "Titre du livre"),
                    const SizedBox(height: 20),

                    _label("Description"),
                    _textField(_descController, "Résumé...", maxLines: 3),
                    const SizedBox(height: 20),

                    // --- AGE RANGE ---
                    _label("Tranche d'âge cible"),
                    DropdownButtonFormField<String>(
                      value: _selectedAgeRange,
                      decoration: _inputStyle(""),
                      items: const [
                        DropdownMenuItem(value: "2-5", child: Text("👶 De 2 à 5 ans")),
                        DropdownMenuItem(value: "6-10", child: Text("👦 De 6 à 10 ans")),
                      ],
                      onChanged: (v) => setState(() => _selectedAgeRange = v),
                    ),
                    const SizedBox(height: 20),

                    // --- PHOTO (Current + New) ---
                    _label("Photo de couverture"),
                    Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: const Color(0xFFFFFBEB), // amber-50
                        borderRadius: BorderRadius.circular(8),
                        border: Border.all(color: const Color(0xFFFEF3C7)), // amber-100
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          if (_newImageFile == null && widget.livre['photo'] != null)
                            Padding(
                              padding: const EdgeInsets.only(bottom: 12),
                              child: Row(
                                children: [
                                  ClipRRect(
                                    borderRadius: BorderRadius.circular(4),
                                    child: Image.network(
                                      "http://10.0.2.2:8000/storage/${widget.livre['photo']}",
                                      width: 64, height: 64, fit: BoxFit.cover,
                                    ),
                                  ),
                                  const SizedBox(width: 12),
                                  const Text("Image actuelle", 
                                    style: TextStyle(color: Color(0xFFB45309), fontSize: 12, fontStyle: FontStyle.italic)),
                                ],
                              ),
                            ),
                          
                          ElevatedButton.icon(
                            onPressed: _pickImage,
                            icon: const Icon(Icons.image_search, size: 18),
                            label: Text(_newImageFile == null ? "Modifier la photo" : "Nouvelle photo choisie ✅"),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: const Color(0xFFFDE68A), // amber-200
                              foregroundColor: const Color(0xFF92400E), // amber-800
                              elevation: 0,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
              const SizedBox(height: 30),

              // --- ACTIONS ---
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  TextButton(
                    onPressed: () => Navigator.pop(context),
                    child: const Text("← Annuler", style: TextStyle(color: Colors.grey, fontWeight: FontWeight.bold)),
                  ),
                  ElevatedButton.icon(
                    onPressed: _isLoading ? null : () => _updateLivre(),
                    icon: const Icon(Icons.refresh, size: 18),
                    label: const Text("METTRE À JOUR"),
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.white,
                      foregroundColor: const Color(0xFF4B5563), // gray-600
                      side: const BorderSide(color: Color(0xFFD1D5DB), width: 2),
                      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                  ),
                ],
              ),
            ],
          ),
        ),
      ),
    );
  }

  // --- UI HELPERS ---
  Widget _label(String text) => Padding(
    padding: const EdgeInsets.only(bottom: 6),
    child: Text(text.toUpperCase(), style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 12, color: Colors.black54)),
  );

  InputDecoration _inputStyle(String hint) => InputDecoration(
    hintText: hint,
    filled: true,
    fillColor: Colors.white,
    contentPadding: const EdgeInsets.all(12),
    border: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Colors.black12)),
    focusedBorder: OutlineInputBorder(borderRadius: BorderRadius.circular(8), borderSide: const BorderSide(color: Color(0xFFF59E0B), width: 2)),
  );

  Widget _textField(TextEditingController ctrl, String hint, {int maxLines = 1}) {
    return TextFormField(controller: ctrl, maxLines: maxLines, decoration: _inputStyle(hint));
  }

  void _updateLivre() {
    // Hna ghadi t-dir l-api call dyal PUT/POST l Laravel
    print("Updating...");
  }
}